<?php

namespace App\Controllers\Admin;

use App\Models\FormationModel;
use App\Models\ModuleModel;
use App\Models\LeconModel;

class Formations extends BaseAdminController
{
    private FormationModel $model;
    private ModuleModel    $moduleModel;
    private LeconModel     $leconModel;

    public function __construct()
    {
        $this->model       = new FormationModel();
        $this->moduleModel = new ModuleModel();
        $this->leconModel  = new LeconModel();
    }

    public function index()
    {
        return $this->render('admin/formations/index', [
            'title'      => 'Formations',
            'formations' => $this->model->orderBy('created_at', 'DESC')->findAll(),
        ]);
    }

    public function create()
    {
        return $this->render('admin/formations/form', [
            'title'     => 'Nouvelle formation',
            'formation' => null,
        ]);
    }

    public function store()
    {
        $data = $this->_formData();
        $data['slug'] = url_title($data['titre'], '-', true);
        $cover = $this->_uploadCover();
        if ($cover) $data['cover_image'] = $cover;
        $id = $this->model->insert($data);
        return redirect()->to(base_url('admin/formations/' . $id))->with('success', 'Formation créée. Ajoutez maintenant les chapitres.');
    }

    /** Page de détail avec gestion modules/leçons */
    public function detail(int $id)
    {
        $formation = $this->model->find($id);
        if (! $formation) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $modules = $this->moduleModel->getWithLecons($id);
        return $this->render('admin/formations/detail', [
            'title'     => 'Chapitres — ' . $formation['titre'],
            'formation' => $formation,
            'modules'   => $modules,
        ]);
    }

    public function edit(int $id)
    {
        $formation = $this->model->find($id);
        if (! $formation) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return $this->render('admin/formations/form', [
            'title'     => 'Modifier formation',
            'formation' => $formation,
        ]);
    }

    public function update(int $id)
    {
        $data = $this->_formData();
        $cover = $this->_uploadCover();
        if ($cover) {
            // Supprimer l'ancienne image si elle existe
            $old = $this->model->find($id);
            if (!empty($old['cover_image'])) {
                $oldPath = FCPATH . 'assets/covers/' . $old['cover_image'];
                if (is_file($oldPath)) unlink($oldPath);
            }
            $data['cover_image'] = $cover;
        }
        $this->model->update($id, $data);
        return redirect()->to(base_url('admin/formations/' . $id))->with('success', 'Formation mise à jour.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to(base_url('admin/formations'))->with('success', 'Formation supprimée.');
    }

    // ─── MODULES ─────────────────────────────────────────────────────

    public function storeModule(int $formationId)
    {
        $titre = trim($this->request->getPost('titre'));
        if ($titre) {
            $this->moduleModel->insert([
                'formation_id' => $formationId,
                'titre'        => $titre,
                'description'  => $this->request->getPost('description') ?? '',
                'position'     => $this->moduleModel->nextPosition($formationId),
            ]);
            $this->model->syncModulesCount($formationId);
        }
        return redirect()->to(base_url('admin/formations/' . $formationId) . '#modules')->with('success', 'Chapitre ajouté.');
    }

    public function updateModule(int $moduleId)
    {
        $module = $this->moduleModel->find($moduleId);
        if (! $module) {
            return redirect()->back()->with('error', 'Chapitre introuvable.');
        }
        $this->moduleModel->update($moduleId, [
            'titre'       => trim($this->request->getPost('titre')),
            'description' => $this->request->getPost('description') ?? '',
        ]);
        return redirect()->to(base_url('admin/formations/' . $module['formation_id']) . '#modules')->with('success', 'Chapitre mis à jour.');
    }

    public function deleteModule(int $moduleId)
    {
        $module = $this->moduleModel->find($moduleId);
        if (! $module) {
            return redirect()->back()->with('error', 'Chapitre introuvable.');
        }
        $formationId = $module['formation_id'];
        // Supprimer les leçons du module
        $this->leconModel->where('module_id', $moduleId)->delete();
        $this->moduleModel->delete($moduleId);
        $this->model->syncModulesCount($formationId);
        return redirect()->to(base_url('admin/formations/' . $formationId) . '#modules')->with('success', 'Chapitre supprimé.');
    }

    // ─── LECONS ──────────────────────────────────────────────────────

    public function storeLecon(int $moduleId)
    {
        $module = $this->moduleModel->find($moduleId);
        if (! $module) {
            return redirect()->back()->with('error', 'Chapitre introuvable.');
        }
        $titre = trim($this->request->getPost('titre'));
        if ($titre) {
            $this->leconModel->insert([
                'module_id' => $moduleId,
                'titre'     => $titre,
                'type'      => $this->request->getPost('type') ?? 'video',
                'duree'     => (int)$this->request->getPost('duree'),
                'video_url' => $this->request->getPost('video_url') ?? '',
                'is_free'   => (int)$this->request->getPost('is_free'),
                'position'  => $this->leconModel->nextPosition($moduleId),
            ]);
        }
        return redirect()->to(base_url('admin/formations/' . $module['formation_id']) . '#module-' . $moduleId)->with('success', 'Leçon ajoutée.');
    }

    public function updateLecon(int $leconId)
    {
        $lecon  = $this->leconModel->find($leconId);
        if (! $lecon) {
            return redirect()->back()->with('error', 'Leçon introuvable.');
        }
        $module = $this->moduleModel->find($lecon['module_id']);
        $this->leconModel->update($leconId, [
            'titre'     => trim($this->request->getPost('titre')),
            'type'      => $this->request->getPost('type') ?? 'video',
            'duree'     => (int)$this->request->getPost('duree'),
            'video_url' => $this->request->getPost('video_url') ?? '',
            'is_free'   => (int)$this->request->getPost('is_free'),
        ]);
        return redirect()->to(base_url('admin/formations/' . $module['formation_id']) . '#module-' . $lecon['module_id'])->with('success', 'Leçon mise à jour.');
    }

    public function deleteLecon(int $leconId)
    {
        $lecon  = $this->leconModel->find($leconId);
        if (! $lecon) {
            return redirect()->back()->with('error', 'Leçon introuvable.');
        }
        $module = $this->moduleModel->find($lecon['module_id']);
        $this->leconModel->delete($leconId);
        return redirect()->to(base_url('admin/formations/' . $module['formation_id']) . '#module-' . $lecon['module_id'])->with('success', 'Leçon supprimée.');
    }

    // ─── HELPERS ─────────────────────────────────────────────────────

    private function _formData(): array
    {
        return [
            'titre'              => $this->request->getPost('titre'),
            'description_courte' => $this->request->getPost('description_courte'),
            'description_longue' => $this->request->getPost('description_longue'),
            'objectifs'          => $this->request->getPost('objectifs'),
            'prerequis'          => $this->request->getPost('prerequis'),
            'niveau'             => $this->request->getPost('niveau'),
            'theme'              => $this->request->getPost('theme'),
            'heures'             => $this->request->getPost('heures'),
            'prix'               => (float) $this->request->getPost('prix'),
            'statut'             => $this->request->getPost('statut') ?? 'bientot',
            'has_certificate'    => (int)(bool)$this->request->getPost('has_certificate'),
            'has_quiz'           => (int)(bool)$this->request->getPost('has_quiz'),
        ];
    }

    private function _uploadCover(): ?string
    {
        $file = $this->request->getFile('cover_image');
        if (! $file || ! $file->isValid() || $file->hasMoved()) return null;
        if ($file->getError() === UPLOAD_ERR_NO_FILE) return null;

        $allowed = ['image/jpeg','image/png','image/webp'];
        if (! in_array($file->getMimeType(), $allowed)) return null;
        if ($file->getSizeByUnit('mb') > 2) return null;

        $name = $file->getRandomName();
        $file->move(FCPATH . 'assets/covers', $name);
        return $name;
    }
}
