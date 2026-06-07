<?php

namespace App\Controllers\Admin;

use App\Models\SettingsModel;

class Parametres extends BaseAdminController
{
    private SettingsModel $model;

    public function __construct()
    {
        $this->model = new SettingsModel();
    }

    public function index()
    {
        return $this->render('admin/parametres/index', [
            'title'    => 'Paramètres',
            'settings' => $this->model->getAll(),
        ]);
    }

    public function update()
    {
        $keys = [
            'tiktok_url', 'tiktok_followers',
            'instagram_url', 'instagram_followers',
            'linkedin_url', 'linkedin_followers',
            'facebook_url', 'facebook_followers',
            'email',
        ];

        $data = [];
        foreach ($keys as $k) {
            $data[$k] = trim($this->request->getPost($k) ?? '');
        }

        $this->model->saveAll($data);
        return redirect()->to(base_url('admin/parametres'))->with('success', 'Paramètres enregistrés.');
    }
}
