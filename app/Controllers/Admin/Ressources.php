<?php

namespace App\Controllers\Admin;

use App\Models\RessourceModel;

class Ressources extends BaseAdminController
{
    private RessourceModel $model;

    public function __construct()
    {
        $this->model = new RessourceModel();
    }

    public function index()
    {
        $ressources = $this->model->orderBy('created_at', 'DESC')->findAll();

        $db = \Config\Database::connect();
        $commandesRows = $db->table('user_resources')
            ->select('resource_id, COUNT(*) AS commandes_count')
            ->groupBy('resource_id')
            ->get()
            ->getResultArray();

        $commandesByResource = [];
        $totalCommandes = 0;
        foreach ($commandesRows as $row) {
            $resourceId = (int) ($row['resource_id'] ?? 0);
            $count = (int) ($row['commandes_count'] ?? 0);
            if ($resourceId > 0) {
                $commandesByResource[$resourceId] = $count;
                $totalCommandes += $count;
            }
        }

        foreach ($ressources as &$ressource) {
            $id = (int) ($ressource['id'] ?? 0);
            $ressource['commandes_count'] = $commandesByResource[$id] ?? 0;
        }
        unset($ressource);

        return $this->render('admin/ressources/index', [
            'title'      => 'Ressources',
            'ressources' => $ressources,
            'totalCommandes' => $totalCommandes,
        ]);
    }

    public function create()
    {
        return $this->render('admin/ressources/form', [
            'title'    => 'Nouvelle ressource',
            'ressource' => null,
        ]);
    }

    public function store()
    {
        $data = $this->_formData();
        if (is_string($data)) {
            return redirect()->back()->withInput()->with('error', $data);
        }
        $data['slug'] = url_title($data['titre'], '-', true);
        $this->model->insert($data);
        return redirect()->to(base_url('admin/ressources'))->with('success', 'Ressource créée.');
    }

    public function edit(int $id)
    {
        $ressource = $this->model->find($id);
        if (! $ressource) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return $this->render('admin/ressources/form', [
            'title'     => 'Modifier ressource',
            'ressource' => $ressource,
        ]);
    }

    public function update(int $id)
    {
        $existing = $this->model->find($id);
        if (! $existing) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = $this->_formData($existing);
        if (is_string($data)) {
            return redirect()->back()->withInput()->with('error', $data);
        }
        $this->model->update($id, $data);
        return redirect()->to(base_url('admin/ressources'))->with('success', 'Ressource mise à jour.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to(base_url('admin/ressources'))->with('success', 'Ressource supprimée.');
    }

    /** @return array|string Form data, or an error message. */
    private function _formData(?array $existing = null): array|string
    {
        $thematique = (string) $this->request->getPost('thematique');
        $secondaires = array_intersect(
            (array) ($this->request->getPost('thematiques_secondaires') ?? []),
            array_keys(RessourceModel::THEMATIQUES)
        );

        $videoInput = trim((string) $this->request->getPost('video_url'));
        $videoId = RessourceModel::youtubeId($videoInput);
        if ($videoInput !== '' && $videoId === null) {
            return 'Lien YouTube invalide. Exemple : https://www.youtube.com/watch?v=XXXXXXXXXXX';
        }

        $fichierPath = $existing['fichier_path'] ?? null;
        if ($this->request->getPost('remove_file')) {
            $fichierPath = null;
        }
        $upload = $this->_uploadFile();
        if (is_string($upload) && str_starts_with($upload, 'ERR:')) {
            return substr($upload, 4);
        }
        if ($upload !== null) {
            $fichierPath = $upload;
        }

        return [
            'titre'              => $this->request->getPost('titre'),
            'description_courte' => $this->request->getPost('description_courte'),
            'description_longue' => $this->request->getPost('description_longue'),
            'type'               => $this->request->getPost('type'),
            'profil'             => $this->request->getPost('profil'),
            'thematique'         => isset(RessourceModel::THEMATIQUES[$thematique]) ? $thematique : null,
            'thematiques_secondaires' => $secondaires !== [] ? implode(',', $secondaires) : null,
            'is_premium'         => (int) (bool) $this->request->getPost('is_premium'),
            'prix'               => (float) $this->request->getPost('prix'),
            'fichier_path'       => $fichierPath,
            'video_url'          => $videoId !== null ? 'https://www.youtube.com/watch?v=' . $videoId : null,
        ];
    }

    /** Stores the upload outside the public folder; returns relative path, null if none, or "ERR:message". */
    private function _uploadFile(): ?string
    {
        $file = $this->request->getFile('fichier');
        if (! $file || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if (! $file->isValid() || $file->hasMoved()) {
            return 'ERR:Échec de l\'envoi du fichier : ' . $file->getErrorString();
        }

        $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'png', 'jpg', 'jpeg', 'mp3', 'mp4'];
        $ext = strtolower($file->getClientExtension());
        if (! in_array($ext, $allowed, true) || $file->guessExtension() === 'php') {
            return 'ERR:Format non autorisé. Formats acceptés : ' . implode(', ', $allowed) . '.';
        }
        if ($file->getSizeByUnit('mb') > 200) {
            return 'ERR:Fichier trop volumineux (200 Mo maximum).';
        }

        $dir = WRITEPATH . 'uploads/ressources';
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $name = bin2hex(random_bytes(8)) . '_' . url_title(pathinfo($file->getClientName(), PATHINFO_FILENAME), '-', true) . '.' . $ext;
        $file->move($dir, $name);

        return 'uploads/ressources/' . $name;
    }
}
