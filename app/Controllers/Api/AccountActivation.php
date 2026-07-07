<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class AccountActivation extends BaseController
{
    public function resend(): ResponseInterface
    {
        $userModel = new UserModel();

        $user = null;
        if (session()->has('user_id')) {
            $user = $userModel->find((int) session()->get('user_id'));
        }

        if (! $user) {
            $email = strtolower(trim((string) ($this->request->getPost('email') ?? session()->get('pending_activation_email') ?? '')));
            if ($email !== '') {
                $user = $userModel->findByEmail($email);
            }
        }

        if (! $user) {
            return $this->response->setJSON(['success' => false, 'message' => 'Utilisateur introuvable.']);
        }

        if (! empty($user['is_active'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ce compte est déjà activé.']);
        }

        $code = (string) random_int(100000, 999999);
        $expiresAt = Time::now()->addMinutes(15)->toDateTimeString();

        $userModel->update($user['id'], [
            'activation_code' => $code,
            'activation_code_expires_at' => $expiresAt,
        ]);

        $emailService = service('email');
        $fromEmail = (string) env('email.fromEmail', 'hello@yesminegharbi.com');
        $fromName = (string) env('email.fromName', 'Yesmine Gharbi');

        $emailService->setFrom($fromEmail, $fromName);
        $emailService->setTo((string) ($user['email'] ?? ''));
        $emailService->setSubject('Nouveau code de vérification');
        $emailService->setMessage(
            "Bonjour,\n\n" .
            "Votre nouveau code de vérification est : " . $code . "\n" .
            "Ce code est valable 15 minutes."
        );

        $sent = (bool) $emailService->send();

        session()->set('pending_activation_email', (string) ($user['email'] ?? ''));

        $payload = [
            'success' => true,
            'message' => 'Un nouveau code de vérification a été envoyé à votre adresse email.',
            'verifyUrl' => site_url('verification-compte?email=' . rawurlencode((string) ($user['email'] ?? ''))),
        ];

        if (! $sent && ENVIRONMENT === 'development') {
            $payload['debug_code'] = $code;
            $payload['message'] = 'Email non envoyé en local. Utilisez le code de test affiché.';
        }

        return $this->response->setJSON($payload);
    }
}
