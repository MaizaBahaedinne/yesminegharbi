<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Contact extends BaseController
{
    public function send(): ResponseInterface
    {
        $sessionUser = session()->get('user') ?? [];
        $isLoggedIn = session()->has('user_id') && is_array($sessionUser) && ! empty($sessionUser['email']);

        $nomFromSession = trim((string) (($sessionUser['prenom'] ?? '') . ' ' . ($sessionUser['nom'] ?? '')));
        $emailFromSession = strtolower(trim((string) ($sessionUser['email'] ?? '')));

        $nom = $isLoggedIn
            ? ($nomFromSession !== '' ? $nomFromSession : $emailFromSession)
            : trim((string) $this->request->getPost('nom'));
        $emailAddress = $isLoggedIn
            ? $emailFromSession
            : strtolower(trim((string) $this->request->getPost('email')));

        $rules = [
            'sujet'   => 'required|max_length[200]',
            'message' => 'required|min_length[20]|max_length[2000]',
        ];

        if (! $isLoggedIn) {
            $rules['nom'] = 'required|max_length[100]';
            $rules['email'] = 'required|valid_email|max_length[255]';
        }

        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        if ($nom === '' || ! filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => [
                    'nom' => 'Informations utilisateur invalides. Veuillez vous reconnecter.',
                ],
            ]);
        }

        $data = [
            'nom'     => $nom,
            'email'   => $emailAddress,
            'sujet'   => $this->request->getPost('sujet'),
            'message' => $this->request->getPost('message'),
        ];

        // Send email notification to admin
        try {
            $email = \Config\Services::email();
            $email->setTo('hello@yesminegharbi.com');
            $email->setFrom($data['email'], $data['nom']);
            $email->setSubject('[Contact] ' . $data['sujet']);
            $email->setMessage(
                "Nom : {$data['nom']}\nEmail : {$data['email']}\n\n{$data['message']}"
            );
            $email->send();
        } catch (\Throwable $e) {
            log_message('error', 'Contact email failed: ' . $e->getMessage());
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Message envoyé ! Je vous réponds sous 48h.',
        ]);
    }
}
