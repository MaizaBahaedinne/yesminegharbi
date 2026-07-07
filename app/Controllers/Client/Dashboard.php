<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ResourceOrderModel;
use App\Models\RessourceModel;
use App\Models\UserModel;
use App\Models\UserResourceModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (! session()->has('user_id')) {
            return redirect()->to(base_url('connexion'));
        }

        $userModel = new UserModel();
        $user = $userModel->find((int) session()->get('user_id'));

        return $this->render('client/dashboard', [
            'title' => 'Mon compte',
            'profileUser' => $user,
        ]);
    }

    public function commandes()
    {
        if (! session()->has('user_id')) {
            return redirect()->to(base_url('connexion'));
        }

        $userId = (int) session()->get('user_id');
        $userResourceModel = new UserResourceModel();
        $ressourceModel = new RessourceModel();
        $orderModel = new ResourceOrderModel();
        $resourceIds = $userResourceModel->getResourceIdsByUser($userId);
        $resources = [];
        $orderTotalsByResource = [];

        if ($resourceIds) {
            $resources = $ressourceModel->whereIn('id', $resourceIds)->findAll();

            $orders = $orderModel
                ->where('user_id', $userId)
                ->whereIn('resource_id', $resourceIds)
                ->orderBy('id', 'DESC')
                ->findAll();

            foreach ($orders as $order) {
                $rid = (int) ($order['resource_id'] ?? 0);
                if ($rid > 0 && ! array_key_exists($rid, $orderTotalsByResource)) {
                    $orderTotalsByResource[$rid] = (float) ($order['total_amount'] ?? 0);
                }
            }
        }

        return $this->render('client/commandes', [
            'title' => 'Mes commandes',
            'resources' => $resources,
            'orderTotalsByResource' => $orderTotalsByResource,
        ]);
    }

    public function updateProfile()
    {
        if (! session()->has('user_id')) {
            return redirect()->to(base_url('connexion'));
        }

        $rules = [
            'prenom' => 'required|alpha_space|max_length[80]',
            'nom' => 'required|alpha_space|max_length[80]',
            'date_naissance' => 'permit_empty|valid_date',
            'situation_actuelle' => "permit_empty|in_list[Etudiant(e),Salarie,Chef d'entreprise,Freelance,A la recherche d'une nouvelle opportunite,Recruteur]",
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('mon-compte'))
                ->with('error', implode(' ', $this->validator->getErrors()));
        }

        $userId = (int) session()->get('user_id');
        $userModel = new UserModel();

        $db = \Config\Database::connect();
        $hasSituationColumn = $db->fieldExists('situation_actuelle', 'users');

        $updateData = [
            'prenom' => trim((string) $this->request->getPost('prenom')),
            'nom' => trim((string) $this->request->getPost('nom')),
            'date_naissance' => trim((string) $this->request->getPost('date_naissance')) ?: null,
        ];

        if ($hasSituationColumn) {
            $updateData['situation_actuelle'] = trim((string) $this->request->getPost('situation_actuelle')) ?: null;
        }

        $userModel->update($userId, $updateData);
        $freshUser = $userModel->find($userId);

        session()->set('user', [
            'id' => $userId,
            'prenom' => $freshUser['prenom'] ?? '',
            'nom' => $freshUser['nom'] ?? '',
            'email' => $freshUser['email'] ?? '',
        ]);

        return redirect()->to(base_url('mon-compte'))->with('success', 'Votre profil a été mis à jour.');
    }

    public function updatePassword()
    {
        if (! session()->has('user_id')) {
            return redirect()->to(base_url('connexion'));
        }

        $currentPassword = (string) $this->request->getPost('current_password');
        $password = (string) $this->request->getPost('password');
        $passwordConfirm = (string) $this->request->getPost('password_confirm');

        if ($currentPassword === '' || $password === '' || $passwordConfirm === '') {
            return redirect()->to(base_url('mon-compte'))->with('error', 'Veuillez renseigner tous les champs du mot de passe.');
        }

        if (strlen($password) < 8) {
            return redirect()->to(base_url('mon-compte'))->with('error', 'Le nouveau mot de passe doit contenir au moins 8 caractères.');
        }

        if ($password !== $passwordConfirm) {
            return redirect()->to(base_url('mon-compte'))->with('error', 'La confirmation du mot de passe ne correspond pas.');
        }

        $userId = (int) session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $storedHash = (string) ($user['password_hash'] ?? '');
        if ($storedHash === '' || ! password_verify($currentPassword, $storedHash)) {
            return redirect()->to(base_url('mon-compte'))->with('error', 'Votre mot de passe actuel est incorrect.');
        }

        $userModel->update($userId, [
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        return redirect()->to(base_url('mon-compte'))->with('success', 'Votre mot de passe a été modifié.');
    }
}
