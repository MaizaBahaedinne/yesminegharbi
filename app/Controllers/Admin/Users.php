<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;

class Users extends BaseAdminController
{
    private UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        $users = $this->model->orderBy('created_at', 'DESC')->findAll();

        return $this->render('admin/users/index', [
            'title' => 'Gestion des utilisateurs',
            'users' => $users,
        ]);
    }

    public function toggleStatus(int $id)
    {
        $user = $this->model->find($id);
        if (! $user) {
            return redirect()->back()->with('error', 'Utilisateur introuvable.');
        }

        $this->model->update($id, ['is_active' => (int) !((bool) ($user['is_active'] ?? 0))]);

        return redirect()->back()->with('success', 'Statut mis à jour.');
    }
}
