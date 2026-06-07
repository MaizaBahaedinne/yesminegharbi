<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function loginForm()
    {
        return $this->render('pages/connexion', ['title' => 'Connexion']);
    }

    public function login()
    {
        // TODO: authenticate user
        return redirect()->to(base_url('mon-compte'));
    }

    public function registerForm()
    {
        return $this->render('pages/inscription', ['title' => 'Créer un compte']);
    }

    public function register()
    {
        // TODO: create account
        return redirect()->to(base_url('connexion'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
