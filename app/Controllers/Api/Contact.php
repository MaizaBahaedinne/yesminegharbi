<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Contact extends BaseController
{
    public function send(): ResponseInterface
    {
        $rules = [
            'nom'     => 'required|max_length[100]',
            'email'   => 'required|valid_email|max_length[255]',
            'sujet'   => 'required|max_length[200]',
            'message' => 'required|min_length[20]|max_length[2000]',
        ];

        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $data = [
            'nom'     => $this->request->getPost('nom'),
            'email'   => $this->request->getPost('email'),
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
