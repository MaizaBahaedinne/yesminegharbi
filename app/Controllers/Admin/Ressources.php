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
        $data = $this->_formData();
        $this->model->update($id, $data);
        return redirect()->to(base_url('admin/ressources'))->with('success', 'Ressource mise à jour.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to(base_url('admin/ressources'))->with('success', 'Ressource supprimée.');
    }

    private function _formData(): array
    {
        return [
            'titre'              => $this->request->getPost('titre'),
            'description_courte' => $this->request->getPost('description_courte'),
            'description_longue' => $this->request->getPost('description_longue'),
            'type'               => $this->request->getPost('type'),
            'profil'             => $this->request->getPost('profil'),
            'is_premium'         => (int) (bool) $this->request->getPost('is_premium'),
            'prix'               => (float) $this->request->getPost('prix'),
            'fichier_path'       => $this->request->getPost('fichier_path'),
        ];
    }
}
