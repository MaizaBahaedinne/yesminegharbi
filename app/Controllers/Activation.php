<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Activation extends BaseController
{
    public function activate(int $userId, string $token)
    {
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if ($user && ($user['activation_token'] ?? null) === $token) {
            $userModel->update($userId, [
                'is_active' => 1,
                'activation_token' => null,
            ]);

            session()->set('user_id', $userId);
            session()->set('user', [
                'id' => $userId,
                'prenom' => $user['prenom'] ?? '',
                'nom' => $user['nom'] ?? '',
                'email' => $user['email'] ?? '',
            ]);

            return redirect()->to(base_url('mon-compte/commandes'))->with('success', 'Votre compte est activé.');
        }

        return redirect()->to(base_url('connexion'))->with('error', 'Lien d’activation invalide.');
    }
}
