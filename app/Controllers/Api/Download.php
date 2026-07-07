<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\NewsletterModel;
use App\Models\RessourceModel;
use App\Models\UserModel;
use App\Models\UserResourceModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Download extends BaseController
{
    public function request(): ResponseInterface
    {
        $rules = [
            'email'            => 'required|valid_email|max_length[255]',
            'prenom'           => 'required|alpha_space|max_length[80]',
            'nom'              => 'required|alpha_space|max_length[80]',
            'date_naissance'   => 'required|valid_date',
            'situation_actuelle' => "required|in_list[Etudiant(e),Salarie,Chef d'entreprise,Freelance,A la recherche d'une nouvelle opportunite,Recruteur]",
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
        $situationActuelle = trim((string) $this->request->getPost('situation_actuelle'));

        $db = \Config\Database::connect();
        $hasSituationColumn = $db->fieldExists('situation_actuelle', 'users');

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);
        $activationCode = (string) random_int(100000, 999999);
        $activationExpiresAt = Time::now()->addMinutes(15)->toDateTimeString();

        if (! $user) {
            $insertData = [
                'prenom' => $prenom,
                'nom' => $nom,
                'date_naissance' => $dateNaissance,
                'email' => $email,
                'activation_token' => bin2hex(random_bytes(16)),
                'activation_code' => $activationCode,
                'activation_code_expires_at' => $activationExpiresAt,
                'is_active' => 0,
            ];

            if ($hasSituationColumn) {
                $insertData['situation_actuelle'] = $situationActuelle;
            }

            $userId = $userModel->insert($insertData, true);
            $user = $userModel->find($userId);
        } else {
            if (! empty($user['is_active'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Un compte existe déjà avec cet email. Connectez-vous pour continuer.',
                    'redirectUrl' => site_url('connexion'),
                ]);
            }

            $updateData = [
                'prenom' => $prenom,
                'nom' => $nom,
                'date_naissance' => $dateNaissance,
                'activation_token' => $user['activation_token'] ?? bin2hex(random_bytes(16)),
                'activation_code' => $activationCode,
                'activation_code_expires_at' => $activationExpiresAt,
                'is_active' => 0,
            ];

            if ($hasSituationColumn) {
                $updateData['situation_actuelle'] = $situationActuelle;
            }

            $userModel->update($user['id'], $updateData);
            $user = $userModel->find($user['id']);
        }

        $emailSent = $this->sendActivationCodeEmail($email, $activationCode);

        $nlModel = new NewsletterModel();
        if (! $nlModel->isSubscribed($email)) {
            $nlModel->insert([
                'email'  => $email,
                'prenom' => $prenom,
                'tag'    => 'gratuit-' . $ressource['slug'],
            ]);
        }

        $userResourceModel = new UserResourceModel();
        $userResourceModel->grantAccess((int) ($user['id'] ?? 0), (int) $ressource['id']);

        session()->set('pending_activation_email', $email);
        $verifyUrl = site_url('verification-compte?email=' . rawurlencode($email));

        $payload = [
            'success' => true,
            'message' => 'Commande enregistrée. Entrez le code de vérification reçu par email pour activer votre compte.',
            'verifyUrl' => $verifyUrl,
        ];

        if (! $emailSent && ENVIRONMENT === 'development') {
            $payload['debug_code'] = $activationCode;
            $payload['message'] = 'Commande enregistrée. Email non envoyé en local, utilisez le code de test affiché.';
        }

        return $this->response->setJSON($payload);
    }

    private function sendActivationCodeEmail(string $email, string $code): bool
    {
        $emailService = service('email');
        $fromEmail = (string) env('email.fromEmail', 'hello@yesminegharbi.com');
        $fromName = (string) env('email.fromName', 'Yesmine Gharbi');

        $emailService->setFrom($fromEmail, $fromName);
        $emailService->setTo($email);
        $emailService->setSubject('Code de vérification de votre compte');
        $emailService->setMessage(
            "Bonjour,\n\n" .
            "Votre code de vérification est : " . $code . "\n" .
            "Ce code est valable 15 minutes.\n\n" .
            "Si vous n'êtes pas à l'origine de cette demande, ignorez cet email."
        );

        return (bool) $emailService->send();
    }
}
