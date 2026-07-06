<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\NewsletterModel;
use App\Models\RessourceModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Download extends BaseController
{
    public function request(): ResponseInterface
    {
        $rules = [
            'email'            => 'required|valid_email|max_length[255]',
            'prenom'           => 'required|alpha_space|max_length[80]',
            'nom'              => 'required|alpha_space|max_length[80]',
            'date_naissance'   => 'required|valid_date',
            'resource_id'      => 'required|integer',
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

        $email = strtolower(trim($this->request->getPost('email')));
        $prenom = trim($this->request->getPost('prenom'));
        $nom = trim($this->request->getPost('nom'));
        $dateNaissance = trim($this->request->getPost('date_naissance'));

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if (! $user) {
            $token = bin2hex(random_bytes(16));
            $userId = $userModel->insert([
                'prenom' => $prenom,
                'nom' => $nom,
                'date_naissance' => $dateNaissance,
                'email' => $email,
                'activation_token' => $token,
                'is_active' => 0,
            ], true);
            $user = $userModel->find($userId);
        } else {
            $token = $user['activation_token'] ?? bin2hex(random_bytes(16));
            $userModel->update($user['id'], [
                'prenom' => $prenom,
                'nom' => $nom,
                'date_naissance' => $dateNaissance,
                'activation_token' => $token,
                'is_active' => 0,
            ]);
            $user = $userModel->find($user['id']);
        }

        $nlModel = new NewsletterModel();
        if (! $nlModel->isSubscribed($email)) {
            $nlModel->insert([
                'email'  => $email,
                'prenom' => $prenom,
                'tag'    => 'gratuit-' . $ressource['slug'],
            ]);
        }

        $activationUrl = site_url('activation/' . ($user['id'] ?? 0) . '/' . $token);
        $downloadUrl = site_url('ressources/download/' . $ressource['slug'] . '?token=' . hash('sha256', $email . $ressource['id']));

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Votre compte a bien été créé. Vérifiez votre email pour activer l’accès.',
            'activationUrl' => $activationUrl,
            'downloadUrl' => $downloadUrl,
        ]);
    }
}
