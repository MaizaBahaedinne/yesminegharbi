<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $helpers = ['url', 'form'];

    public function loginForm()
    {
        if (session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin'));
        }
        return view('admin/login', ['title' => 'Administration']);
    }

    public function login()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $adminEmail    = env('admin.email', '');
        $adminPassword = env('admin.password', '');

        if ($email === $adminEmail && $password === $adminPassword) {
            session()->set([
                'admin_logged_in' => true,
                'admin_email'     => $email,
            ]);
            return redirect()->to(base_url('admin'));
        }

        return redirect()->back()->with('error', 'Identifiants incorrects')->withInput();
    }

    public function logout()
    {
        session()->remove(['admin_logged_in', 'admin_email']);
        return redirect()->to(base_url('admin/login'));
    }
}
