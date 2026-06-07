<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\NewsletterModel;
use App\Models\RessourceModel;
use CodeIgniter\HTTP\ResponseInterface;

class Download extends BaseController
{
    public function request(): ResponseInterface
    {
        $rules = [
            'email'       => 'required|valid_email|max_length[255]',
            'prenom'      => 'required|alpha_space|max_length[80]',
            'resource_id' => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $ressourceModel = new RessourceModel();
        $ressource = $ressourceModel->find((int) $this->request->getPost('resource_id'));

        if (! $ressource || $ressource['is_premium']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ressource introuvable.']);
        }

        // Save/update subscriber with tag
        $nlModel = new NewsletterModel();
        $email   = $this->request->getPost('email');
        $prenom  = $this->request->getPost('prenom');

        if (! $nlModel->isSubscribed($email)) {
            $nlModel->insert([
                'email'  => $email,
                'prenom' => $prenom,
                'tag'    => 'gratuit-' . $ressource['slug'],
            ]);
        }

        // In production: send email with download link via MailerLite
        // For now return a direct download token/URL
        $downloadUrl = site_url('ressources/download/' . $ressource['slug'] . '?token=' . hash('sha256', $email . $ressource['id']));

        return $this->response->setJSON([
            'success'      => true,
            'message'      => 'Lien envoyé sur ' . $email . ' !',
            'downloadUrl'  => $downloadUrl,
        ]);
    }
}
