<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\UserResourceModel;
use CodeIgniter\HTTP\ResponseInterface;

class RessourceAccess extends BaseController
{
    public function claim(): ResponseInterface
    {
        if (! session()->has('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Connexion requise.']);
        }

        $resourceId = (int) $this->request->getPost('resource_id');
        if ($resourceId <= 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ressource invalide.']);
        }

        $userId = (int) session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (! $user || empty($user['is_active'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Votre compte doit être activé.']);
        }

        $userResourceModel = new UserResourceModel();
        $userResourceModel->grantAccess($userId, $resourceId);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Commande confirmée.',
            'downloadUrl' => site_url('ressources/download/' . $this->request->getPost('slug') . '?token=' . hash('sha256', ($user['email'] ?? '') . $resourceId)),
        ]);
    }
}
