<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

class Auth extends BaseController
{
    public function loginForm()
    {
        return $this->render('pages/connexion', [
            'title' => 'Connexion',
            'activeTab' => 'login',
        ]);
    }

    public function login()
    {
        $email = strtolower(trim($this->request->getPost('email')));
        $password = (string) $this->request->getPost('password');

        if ($email === '' || $password === '') {
            return redirect()->back()->with('error', 'Veuillez renseigner votre email et votre mot de passe.')->withInput();
        }

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if (! $user) {
            return redirect()->back()->with('error', 'Aucun compte ne correspond à cet email.')->withInput();
        }

        if (empty($user['is_active'])) {
            session()->setFlashdata('pending_email', $email);
            return redirect()->to(base_url('compte-en-attente'));
        }

        $storedHash = (string) ($user['password_hash'] ?? '');
        if ($storedHash !== '' && password_verify($password, $storedHash)) {
            session()->set([
                'user_id' => (int) $user['id'],
                'user' => [
                    'id' => (int) $user['id'],
                    'prenom' => $user['prenom'] ?? '',
                    'nom' => $user['nom'] ?? '',
                    'email' => $user['email'] ?? '',
                ],
            ]);

            return redirect()->to(base_url('mon-compte'));
        }

        return redirect()->back()->with('error', 'Identifiants incorrects.')->withInput();
    }

    public function googleRedirect()
    {
        $clientId = trim((string) env('google.clientId', ''));
        $redirectUri = trim((string) env('google.redirectUri', site_url('auth/google/callback')));

        if ($clientId === '') {
            return redirect()->to(base_url('connexion'))->with('error', 'Connexion Google indisponible. Configuration manquante.');
        }

        $state = bin2hex(random_bytes(16));
        session()->set('google_oauth_state', $state);

        $query = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'prompt' => 'select_account',
        ]);

        return redirect()->to('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
    }

    public function googleCallback()
    {
        $expectedState = (string) session()->get('google_oauth_state');
        $state = (string) $this->request->getGet('state');
        session()->remove('google_oauth_state');

        if ($expectedState === '' || ! hash_equals($expectedState, $state)) {
            return redirect()->to(base_url('connexion'))->with('error', 'Session Google invalide. Veuillez réessayer.');
        }

        if ($this->request->getGet('error')) {
            return redirect()->to(base_url('connexion'))->with('error', 'Connexion Google annulée.');
        }

        $code = (string) $this->request->getGet('code');
        if ($code === '') {
            return redirect()->to(base_url('connexion'))->with('error', 'Code Google manquant.');
        }

        $clientId = trim((string) env('google.clientId', ''));
        $clientSecret = trim((string) env('google.clientSecret', ''));
        $redirectUri = trim((string) env('google.redirectUri', site_url('auth/google/callback')));

        if ($clientId === '' || $clientSecret === '') {
            return redirect()->to(base_url('connexion'))->with('error', 'Connexion Google indisponible. Configuration manquante.');
        }

        $http = service('curlrequest', ['http_errors' => false]);

        try {
            $tokenResponse = $http->post('https://oauth2.googleapis.com/token', [
                'form_params' => [
                    'code' => $code,
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'redirect_uri' => $redirectUri,
                    'grant_type' => 'authorization_code',
                ],
            ]);
        } catch (\Throwable $e) {
            return redirect()->to(base_url('connexion'))->with('error', 'Connexion Google indisponible.');
        }

        $tokenData = json_decode((string) $tokenResponse->getBody(), true);
        $accessToken = (string) ($tokenData['access_token'] ?? '');
        if ($accessToken === '') {
            return redirect()->to(base_url('connexion'))->with('error', 'Impossible de valider votre compte Google.');
        }

        try {
            $userInfoResponse = $http->get('https://openidconnect.googleapis.com/v1/userinfo', [
                'headers' => ['Authorization' => 'Bearer ' . $accessToken],
            ]);
        } catch (\Throwable $e) {
            return redirect()->to(base_url('connexion'))->with('error', 'Impossible de récupérer votre profil Google.');
        }

        $googleUser = json_decode((string) $userInfoResponse->getBody(), true);
        $email = strtolower(trim((string) ($googleUser['email'] ?? '')));
        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->to(base_url('connexion'))->with('error', 'Email Google introuvable.');
        }

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        $prenom = trim((string) ($googleUser['given_name'] ?? ''));
        $nom = trim((string) ($googleUser['family_name'] ?? ''));
        if ($prenom === '' && $nom === '') {
            $fullName = trim((string) ($googleUser['name'] ?? ''));
            if ($fullName !== '') {
                $parts = preg_split('/\s+/', $fullName);
                $prenom = (string) ($parts[0] ?? '');
                $nom = trim(implode(' ', array_slice($parts, 1)));
            }
        }

        if (! $user) {
            $userId = (int) $userModel->insert([
                'prenom' => $prenom,
                'nom' => $nom,
                'email' => $email,
                'is_active' => 1,
                'role' => 'user',
                'activation_token' => null,
                'activation_code' => null,
                'activation_code_expires_at' => null,
            ], true);
            $user = $userModel->find($userId);
        } else {
            $updateData = [
                'is_active' => 1,
                'activation_token' => null,
                'activation_code' => null,
                'activation_code_expires_at' => null,
            ];

            if (($user['prenom'] ?? '') === '' && $prenom !== '') {
                $updateData['prenom'] = $prenom;
            }
            if (($user['nom'] ?? '') === '' && $nom !== '') {
                $updateData['nom'] = $nom;
            }

            $userModel->update((int) $user['id'], $updateData);
            $user = $userModel->find((int) $user['id']);
        }

        session()->set([
            'user_id' => (int) ($user['id'] ?? 0),
            'user' => [
                'id' => (int) ($user['id'] ?? 0),
                'prenom' => $user['prenom'] ?? '',
                'nom' => $user['nom'] ?? '',
                'email' => $user['email'] ?? '',
            ],
        ]);

        return redirect()->to(base_url('mon-compte'))->with('success', 'Connexion Google réussie.');
    }

    public function pendingActivation()
    {
        $email = (string) (session()->getFlashdata('pending_email') ?? session()->get('pending_activation_email') ?? '');

        if ($email === '') {
            return redirect()->to(base_url('connexion'));
        }

        return $this->render('pages/compte-en-attente', [
            'title' => 'Vérification du compte',
            'email' => $email,
        ]);
    }

    public function verificationForm()
    {
        $email = (string) ($this->request->getGet('email') ?? session()->get('pending_activation_email') ?? '');
        return $this->render('pages/verification-compte', [
            'title' => 'Vérification du compte',
            'email' => $email,
        ]);
    }

    public function verifyCode()
    {
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $code = trim((string) $this->request->getPost('code'));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || ! preg_match('/^\d{6}$/', $code)) {
            return redirect()->back()->with('error', 'Email ou code invalide.')->withInput();
        }

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if (! $user) {
            return redirect()->back()->with('error', 'Aucun compte en attente pour cet email.')->withInput();
        }

        if (! empty($user['is_active'])) {
            return redirect()->to(base_url('connexion'))->with('success', 'Ce compte est déjà activé.');
        }

        $storedCode = (string) ($user['activation_code'] ?? '');
        $expiresAt = (string) ($user['activation_code_expires_at'] ?? '');

        if ($storedCode === '' || $expiresAt === '' || ! hash_equals($storedCode, $code) || ! Time::parse($expiresAt)->isAfter(Time::now())) {
            return redirect()->back()->with('error', 'Code invalide ou expiré.')->withInput();
        }

        session()->set('activation_verified_user_id', (int) $user['id']);
        session()->set('pending_activation_email', $email);

        return redirect()->to(base_url('finaliser-compte'));
    }

    public function completeRegistrationForm()
    {
        $userId = (int) session()->get('activation_verified_user_id');
        if ($userId <= 0) {
            return redirect()->to(base_url('verification-compte'))->with('error', 'Veuillez valider votre code avant de créer le mot de passe.');
        }

        return $this->render('pages/finaliser-compte', [
            'title' => 'Finaliser votre compte',
            'email' => (string) session()->get('pending_activation_email'),
        ]);
    }

    public function completeRegistration()
    {
        $userId = (int) session()->get('activation_verified_user_id');
        if ($userId <= 0) {
            return redirect()->to(base_url('verification-compte'))->with('error', 'Session expirée. Veuillez revalider votre code.');
        }

        $password = (string) $this->request->getPost('password');
        $passwordConfirm = (string) $this->request->getPost('password_confirm');

        if (strlen($password) < 8) {
            return redirect()->back()->with('error', 'Le mot de passe doit contenir au moins 8 caractères.')->withInput();
        }

        if ($password !== $passwordConfirm) {
            return redirect()->back()->with('error', 'La confirmation du mot de passe ne correspond pas.')->withInput();
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);
        if (! $user) {
            session()->remove(['activation_verified_user_id', 'pending_activation_email']);
            return redirect()->to(base_url('verification-compte'))->with('error', 'Compte introuvable.');
        }

        $userModel->update($userId, [
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'is_active' => 1,
            'activation_token' => null,
            'activation_code' => null,
            'activation_code_expires_at' => null,
        ]);

        $freshUser = $userModel->find($userId);
        session()->remove(['activation_verified_user_id', 'pending_activation_email']);
        session()->set('user_id', $userId);
        session()->set('user', [
            'id' => $userId,
            'prenom' => $freshUser['prenom'] ?? '',
            'nom' => $freshUser['nom'] ?? '',
            'email' => $freshUser['email'] ?? '',
        ]);

        return redirect()->to(base_url('mon-compte/commandes'))->with('success', 'Votre compte est activé et vérifié.');
    }

    public function forgotPassword()
    {
        return $this->render('pages/mot-de-passe-oublie', [
            'title' => 'Mot de passe oublié',
        ]);
    }

    public function sendResetLink()
    {
        $email = strtolower(trim((string) $this->request->getPost('email')));

        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Veuillez entrer une adresse email valide.')->withInput();
        }

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $tokenHash = hash('sha256', $token);
            $expiresAt = Time::now()->addHours(1)->toDateTimeString();

            $userModel->update((int) $user['id'], [
                'reset_token_hash' => $tokenHash,
                'reset_token_expires_at' => $expiresAt,
            ]);

            $resetUrl = site_url('reinitialiser-mot-de-passe/' . (int) $user['id'] . '/' . $token);

            $emailService = service('email');
            $fromEmail = (string) env('email.fromEmail', 'hello@yesminegharbi.com');
            $fromName = (string) env('email.fromName', 'Yesmine Gharbi');

            $emailService->setFrom($fromEmail, $fromName);
            $emailService->setTo($email);
            $emailService->setSubject('Réinitialisation de votre mot de passe');
            $emailService->setMessage(
                "Bonjour,\n\n" .
                "Vous avez demandé la réinitialisation de votre mot de passe.\n" .
                "Cliquez sur ce lien (valable 1 heure) :\n" .
                $resetUrl . "\n\n" .
                "Si vous n'êtes pas à l'origine de cette demande, ignorez simplement cet email."
            );

            if (! $emailService->send() && ENVIRONMENT === 'development') {
                return redirect()->to(base_url('mot-de-passe-oublie'))
                    ->with('success', 'Lien de réinitialisation généré (mode développement).')
                    ->with('debug_reset_url', $resetUrl);
            }
        }

        return redirect()->to(base_url('mot-de-passe-oublie'))
            ->with('success', 'Si un compte existe avec cet email, un lien de réinitialisation a été envoyé.');
    }

    public function resetPasswordForm(int $userId, string $token)
    {
        if (! $this->isValidResetToken($userId, $token)) {
            return redirect()->to(base_url('mot-de-passe-oublie'))
                ->with('error', 'Ce lien de réinitialisation est invalide ou expiré.');
        }

        return $this->render('pages/reinitialiser-mot-de-passe', [
            'title' => 'Nouveau mot de passe',
            'userId' => $userId,
            'token' => $token,
        ]);
    }

    public function resetPassword(int $userId, string $token)
    {
        if (! $this->isValidResetToken($userId, $token)) {
            return redirect()->to(base_url('mot-de-passe-oublie'))
                ->with('error', 'Ce lien de réinitialisation est invalide ou expiré.');
        }

        $password = (string) $this->request->getPost('password');
        $passwordConfirm = (string) $this->request->getPost('password_confirm');

        if (strlen($password) < 8) {
            return redirect()->back()->with('error', 'Le mot de passe doit contenir au moins 8 caractères.')->withInput();
        }

        if ($password !== $passwordConfirm) {
            return redirect()->back()->with('error', 'La confirmation du mot de passe ne correspond pas.')->withInput();
        }

        $userModel = new UserModel();
        $userModel->update($userId, [
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'reset_token_hash' => null,
            'reset_token_expires_at' => null,
        ]);

        return redirect()->to(base_url('connexion'))
            ->with('success', 'Votre mot de passe a été réinitialisé. Vous pouvez vous connecter.');
    }

    private function isValidResetToken(int $userId, string $token): bool
    {
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (! $user) {
            return false;
        }

        $tokenHash = (string) ($user['reset_token_hash'] ?? '');
        $expiresAt = (string) ($user['reset_token_expires_at'] ?? '');

        if ($tokenHash === '' || $expiresAt === '') {
            return false;
        }

        if (! hash_equals($tokenHash, hash('sha256', $token))) {
            return false;
        }

        return Time::parse($expiresAt)->isAfter(Time::now());
    }

    public function registerForm()
    {
        return $this->render('pages/connexion', [
            'title' => 'Créer un compte',
            'activeTab' => 'register',
        ]);
    }

    public function register()
    {
        $rules = [
            'email' => 'required|valid_email|max_length[255]',
            'prenom' => 'required|alpha_space|max_length[80]',
            'nom' => 'required|alpha_space|max_length[80]',
            'date_naissance' => 'required|valid_date',
            'situation_actuelle' => "required|in_list[Etudiant(e),Salarie,Chef d'entreprise,Freelance,A la recherche d'une nouvelle opportunite,Recruteur]",
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('inscription'))->with('error', implode(' ', $this->validator->getErrors()))->withInput();
        }

        $email = strtolower(trim((string) $this->request->getPost('email')));
        $prenom = trim((string) $this->request->getPost('prenom'));
        $nom = trim((string) $this->request->getPost('nom'));
        $dateNaissance = trim((string) $this->request->getPost('date_naissance'));
        $situationActuelle = trim((string) $this->request->getPost('situation_actuelle'));

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if ($user && ! empty($user['is_active'])) {
            return redirect()->to(base_url('connexion'))->with('error', 'Un compte existe déjà avec cet email. Connectez-vous.');
        }

        $activationCode = (string) random_int(100000, 999999);
        $activationExpiresAt = Time::now()->addMinutes(15)->toDateTimeString();
        $token = bin2hex(random_bytes(16));

        $db = \Config\Database::connect();
        $hasSituationColumn = $db->fieldExists('situation_actuelle', 'users');

        $data = [
            'prenom' => $prenom,
            'nom' => $nom,
            'date_naissance' => $dateNaissance,
            'email' => $email,
            'activation_token' => $token,
            'activation_code' => $activationCode,
            'activation_code_expires_at' => $activationExpiresAt,
            'is_active' => 0,
        ];

        if ($hasSituationColumn) {
            $data['situation_actuelle'] = $situationActuelle;
        }

        if (! $user) {
            $userModel->insert($data);
        } else {
            $userModel->update((int) $user['id'], $data);
        }

        $sent = $this->sendActivationCodeEmail($email, $activationCode);

        session()->set('pending_activation_email', $email);

        $redirect = redirect()->to(base_url('verification-compte?email=' . rawurlencode($email)));
        if (! $sent && ENVIRONMENT === 'development') {
            return $redirect->with('success', 'Code non envoyé en local. Utilisez ce code: ' . $activationCode);
        }

        return $redirect->with('success', 'Un code de vérification vous a été envoyé par email.');
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

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
