<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Libraries\CvAtsScorer;
use App\Libraries\CvDocx;
use App\Models\CvAtsTestModel;
use App\Models\CvModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Cv extends BaseController
{
    private CvModel $cvs;
    private CvAtsTestModel $tests;

    public function __construct()
    {
        $this->cvs = new CvModel();
        $this->tests = new CvAtsTestModel();
    }

    public function landing()
    {
        return $this->render('pages/cv-ats', [
            'page_title'       => 'Créer un CV ATS et tester sa compatibilité — Yesmine Gharbi',
            'page_description' => 'Créez gratuitement un CV structuré pour les ATS et testez-le contre une offre d’emploi.',
        ]);
    }

    public function index()
    {
        if (($r = $this->requireLogin()) !== null) {
            return $r;
        }

        return $this->render('client/cv/index', [
            'page_title' => 'Mes CV — Yesmine Gharbi',
            'cvs'        => $this->cvs->forUser($this->userId()),
            'maxCv'      => CvModel::MAX_FREE_CV,
            'testsLeft'  => max(0, CvAtsTestModel::FREE_TESTS_PER_DAY - $this->tests->countToday($this->userId())),
        ]);
    }

    public function create()
    {
        if (($r = $this->requireLogin()) !== null) {
            return $r;
        }
        $userId = $this->userId();

        if (count($this->cvs->forUser($userId)) >= CvModel::MAX_FREE_CV) {
            return redirect()->to(base_url('mon-compte/cv'))
                ->with('error', 'Vous avez atteint la limite de ' . CvModel::MAX_FREE_CV . ' CV gratuits. Supprimez-en un pour en créer un nouveau.');
        }

        $langue = (string) $this->request->getPost('langue');
        $langue = isset(CvModel::LANGUES[$langue]) ? $langue : 'fr';
        $titre = trim((string) $this->request->getPost('titre')) ?: 'Mon CV';

        $user = session()->get('user') ?? [];
        $data = CvModel::withDefaults([
            'personal' => [
                'full_name' => trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')),
                'email'     => (string) ($user['email'] ?? ''),
            ],
        ]);

        $id = $this->cvs->insert([
            'user_id' => $userId,
            'titre'   => mb_substr($titre, 0, 120),
            'langue'  => $langue,
            'data'    => json_encode($data, JSON_UNESCAPED_UNICODE),
        ]);

        return redirect()->to(base_url('mon-compte/cv/' . $id));
    }

    public function edit(int $id)
    {
        if (($r = $this->requireLogin()) !== null) {
            return $r;
        }
        $cv = $this->owned($id);

        return $this->render('client/cv/edit', [
            'page_title' => $cv['titre'] . ' — Mes CV',
            'cv'         => $cv,
        ]);
    }

    public function save(int $id)
    {
        if (($r = $this->requireLogin()) !== null) {
            return $r;
        }
        $cv = $this->owned($id);

        $data = CvModel::fromInput((array) $this->request->getPost());
        $titre = trim((string) $this->request->getPost('titre')) ?: $cv['titre'];

        $this->cvs->update($id, [
            'titre' => mb_substr($titre, 0, 120),
            'data'  => json_encode($data, JSON_UNESCAPED_UNICODE),
        ]);

        $next = (string) $this->request->getPost('next');
        $target = match ($next) {
            'ats'     => 'mon-compte/cv/' . $id . '/test-ats',
            'preview' => 'mon-compte/cv/' . $id . '/apercu',
            default   => 'mon-compte/cv/' . $id,
        };

        return redirect()->to(base_url($target))->with('success', 'CV enregistré.');
    }

    public function delete(int $id)
    {
        if (($r = $this->requireLogin()) !== null) {
            return $r;
        }
        $this->owned($id);

        $this->tests->where('cv_id', $id)->where('user_id', $this->userId())->delete();
        $this->cvs->delete($id);

        return redirect()->to(base_url('mon-compte/cv'))->with('success', 'CV supprimé.');
    }

    public function preview(int $id)
    {
        if (($r = $this->requireLogin()) !== null) {
            return $r;
        }
        $cv = $this->owned($id);

        return view('client/cv/print', ['cv' => $cv, 'autoPrint' => $this->request->getGet('print') === '1']);
    }

    public function docx(int $id)
    {
        if (($r = $this->requireLogin()) !== null) {
            return $r;
        }
        $cv = $this->owned($id);

        $name = url_title($cv['data']['personal']['full_name'] ?: $cv['titre'], '-', true) ?: 'cv';

        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
            ->setHeader('Content-Disposition', 'attachment; filename="CV-' . $name . '.docx"')
            ->setBody((new CvDocx())->build($cv['data'], $cv['langue']));
    }

    public function atsForm(int $id)
    {
        if (($r = $this->requireLogin()) !== null) {
            return $r;
        }
        $cv = $this->owned($id);

        return $this->render('client/cv/ats', [
            'page_title' => 'Test ATS — ' . $cv['titre'],
            'cv'         => $cv,
            'history'    => $this->tests->forCv($id, $this->userId()),
            'testsLeft'  => max(0, CvAtsTestModel::FREE_TESTS_PER_DAY - $this->tests->countToday($this->userId())),
            'test'       => null,
        ]);
    }

    public function atsRun(int $id)
    {
        if (($r = $this->requireLogin()) !== null) {
            return $r;
        }
        $cv = $this->owned($id);
        $userId = $this->userId();

        if ($this->tests->countToday($userId) >= CvAtsTestModel::FREE_TESTS_PER_DAY) {
            return redirect()->to(base_url('mon-compte/cv/' . $id . '/test-ats'))
                ->with('error', 'Vous avez utilisé vos ' . CvAtsTestModel::FREE_TESTS_PER_DAY . ' tests ATS gratuits aujourd’hui. Revenez demain !');
        }

        $offer = trim(strip_tags((string) $this->request->getPost('offer_text')));
        $jobTitle = mb_substr(trim(strip_tags((string) $this->request->getPost('job_title'))), 0, 190);

        if (mb_strlen($offer) < 200) {
            return redirect()->back()->withInput()
                ->with('error', 'Collez le texte complet de l’offre (au moins 200 caractères) pour un test fiable.');
        }
        $offer = mb_substr($offer, 0, 15000);

        $result = (new CvAtsScorer())->score($cv['data'], $cv['langue'], $offer, $jobTitle);

        $testId = $this->tests->insert([
            'user_id'    => $userId,
            'cv_id'      => $id,
            'job_title'  => $jobTitle,
            'offer_text' => $offer,
            'score'      => $result['score'],
            'result'     => json_encode($result, JSON_UNESCAPED_UNICODE),
        ]);

        return redirect()->to(base_url('mon-compte/cv/test/' . $testId));
    }

    public function atsResult(int $testId)
    {
        if (($r = $this->requireLogin()) !== null) {
            return $r;
        }
        $test = $this->tests->where('id', $testId)->where('user_id', $this->userId())->first();
        if (! $test) {
            throw PageNotFoundException::forPageNotFound();
        }
        $cv = $this->owned((int) $test['cv_id']);
        $test['result'] = json_decode((string) $test['result'], true) ?: [];

        return $this->render('client/cv/ats', [
            'page_title' => 'Résultat du test ATS — ' . $cv['titre'],
            'cv'         => $cv,
            'history'    => $this->tests->forCv((int) $cv['id'], $this->userId()),
            'testsLeft'  => max(0, CvAtsTestModel::FREE_TESTS_PER_DAY - $this->tests->countToday($this->userId())),
            'test'       => $test,
        ]);
    }

    private function requireLogin()
    {
        if (! session()->has('user_id')) {
            return redirect()->to(base_url('connexion'))->with('error', 'Connectez-vous pour créer votre CV et le tester.');
        }

        return null;
    }

    private function userId(): int
    {
        return (int) session()->get('user_id');
    }

    private function owned(int $id): array
    {
        $cv = $this->cvs->findOwned($id, $this->userId());
        if (! $cv) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $cv;
    }
}
