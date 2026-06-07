<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        if (! session()->has('user_id')) {
            return redirect()->to(base_url('connexion'));
        }
        return $this->render('client/dashboard', ['title' => 'Mon compte']);
    }

    public function commandes()
    {
        if (! session()->has('user_id')) {
            return redirect()->to(base_url('connexion'));
        }
        return $this->render('client/commandes', ['title' => 'Mes commandes']);
    }
}
