<?php

namespace App\Controllers\Admin;

use App\Models\SettingsModel;

class Socials extends BaseAdminController
{
    private SettingsModel $model;

    public function __construct()
    {
        $this->model = new SettingsModel();
    }

    public function index()
    {
        return $this->render('admin/socials/index', [
            'title'    => 'Connexions sociales',
            'settings' => $this->model->getAll(),
        ]);
    }

    public function update()
    {
        $keys = [
            'facebook_app_id',
            'facebook_app_secret',
            'facebook_access_token',
            'facebook_page_id',
            'instagram_access_token',
            'linkedin_client_id',
            'linkedin_client_secret',
            'linkedin_access_token',
            'tiktok_client_key',
            'tiktok_client_secret',
            'tiktok_access_token',
        ];

        $data = [];
        foreach ($keys as $key) {
            $data[$key] = trim($this->request->getPost($key) ?? '');
        }

        $this->model->saveAll($data);

        return redirect()->to(base_url('admin/socials'))->with('success', 'Informations de connexion enregistrées.');
    }
}
