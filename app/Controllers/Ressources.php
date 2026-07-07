<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\ResourceOrderModel;
use App\Models\RessourceModel;
use App\Models\UserModel;
use App\Models\UserResourceModel;
use CodeIgniter\I18n\Time;

class Ressources extends BaseController
{
    private RessourceModel $model;

    public function __construct()
    {
        $this->model = new RessourceModel();
    }

    public function index(): string
    {
        return $this->renderUnifiedResourcesPage();
    }

    public function gratuites()
    {
        return redirect()->to(base_url('ressources?access=gratuit'));
    }

    public function premium()
    {
        $type = (string) ($this->request->getGet('type') ?? 'tous');
        $profil = (string) ($this->request->getGet('profil') ?? 'tous');
        return redirect()->to(base_url('ressources?access=premium&type=' . rawurlencode($type) . '&profil=' . rawurlencode($profil)));
    }

    public function detail(string $slug): string
    {
        $ressource = $this->model->getBySlug($slug);

        if (! $ressource) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->model->incrementViewCount((int) $ressource['id']);
        $ressource = $this->model->getBySlug($slug) ?? $ressource;

        $userResourceModel = new UserResourceModel();
        $userId = session()->get('user_id');
        $hasAccess = false;

        if ($userId && !empty($ressource['id'])) {
            $hasAccess = $userResourceModel->hasAccess((int) $userId, (int) $ressource['id']);
        }

        $data = [
            'page_title'       => $ressource['titre'] . ' — Ressources · Yesmine Gharbi',
            'page_description' => $ressource['description_courte'],
            'ressource'        => $ressource,
            'hasAccess'        => $hasAccess,
        ];

        return $this->render('pages/ressource-detail', $data);
    }

    public function download(string $slug)
    {
        if (! session()->has('user_id')) {
            return redirect()->to(base_url('connexion'))->with('error', 'Connexion requise pour télécharger cette ressource.');
        }

        $ressource = $this->model->getBySlug($slug);
        if (! $ressource || empty($ressource['fichier_path'])) {
            throw PageNotFoundException::forPageNotFound();
        }

        $userId = (int) session()->get('user_id');
        $userResourceModel = new UserResourceModel();
        $hasAccess = $userResourceModel->hasAccess($userId, (int) ($ressource['id'] ?? 0));

        if (! $hasAccess) {
            return redirect()->to(base_url('mon-compte/commandes'))->with('error', 'Cette ressource n\'est pas disponible pour votre compte.');
        }

        $relativePath = ltrim((string) $ressource['fichier_path'], '/\\');
        $absolutePath = FCPATH . $relativePath;

        if (! is_file($absolutePath)) {
            return redirect()->to(base_url('mon-compte/commandes'))->with('error', 'Fichier introuvable.');
        }

        if (! $this->isDownloadVerified((int) ($ressource['id'] ?? 0))) {
            return redirect()->to(base_url('ressources/download/request-code/' . $slug))
                ->with('error', 'Veuillez valider votre code de sécurité avant le téléchargement.');
        }

        $this->model->incrementDownloadCount((int) ($ressource['id'] ?? 0));

        return $this->response->download($absolutePath, null);
    }

    public function requestDownloadCode(string $slug)
    {
        if (! session()->has('user_id')) {
            return redirect()->to(base_url('connexion'))->with('error', 'Connexion requise.');
        }

        $ressource = $this->model->getBySlug($slug);
        if (! $ressource || empty($ressource['fichier_path'])) {
            throw PageNotFoundException::forPageNotFound();
        }

        $userId = (int) session()->get('user_id');
        $userResourceModel = new UserResourceModel();
        if (! $userResourceModel->hasAccess($userId, (int) ($ressource['id'] ?? 0))) {
            return redirect()->to(base_url('mon-compte/commandes'))->with('error', 'Cette ressource n\'est pas disponible pour votre compte.');
        }

        if (! $this->sendPremiumDownloadCode((int) ($ressource['id'] ?? 0), $slug)) {
            return redirect()->back()->with('error', 'Impossible d\'envoyer le code de vérification pour le moment.');
        }

        return redirect()->to(base_url('ressources/download/verification/' . $slug))
            ->with('success', 'Un code de vérification à 6 chiffres vient d\'être envoyé à votre email.');
    }

    public function downloadVerificationForm(string $slug)
    {
        if (! session()->has('user_id')) {
            return redirect()->to(base_url('connexion'))->with('error', 'Connexion requise.');
        }

        $ressource = $this->model->getBySlug($slug);
        if (! $ressource || empty($ressource['fichier_path'])) {
            throw PageNotFoundException::forPageNotFound();
        }

        $userId = (int) session()->get('user_id');
        $userResourceModel = new UserResourceModel();
        if (! $userResourceModel->hasAccess($userId, (int) ($ressource['id'] ?? 0))) {
            return redirect()->to(base_url('mon-compte/commandes'))->with('error', 'Accès non autorisé à cette ressource.');
        }

        return $this->render('pages/verification-telechargement', [
            'page_title' => 'Vérifier mon identité — Téléchargement',
            'page_description' => 'Validation par code email avant téléchargement premium.',
            'ressource' => $ressource,
        ]);
    }

    public function verifyDownloadCode(string $slug)
    {
        if (! session()->has('user_id')) {
            return redirect()->to(base_url('connexion'))->with('error', 'Connexion requise.');
        }

        $ressource = $this->model->getBySlug($slug);
        if (! $ressource || empty($ressource['fichier_path'])) {
            throw PageNotFoundException::forPageNotFound();
        }

        $code = trim((string) $this->request->getPost('code'));
        if (! preg_match('/^\d{6}$/', $code)) {
            return redirect()->back()->with('error', 'Code invalide. Entrez 6 chiffres.')->withInput();
        }

        $resourceId = (int) ($ressource['id'] ?? 0);
        $sessionKey = 'download_verification_' . $resourceId;
        $verification = session()->get($sessionKey);

        if (! is_array($verification)) {
            return redirect()->to(base_url('ressources/download/request-code/' . $slug))
                ->with('error', 'Aucun code actif. Veuillez demander un nouveau code.');
        }

        $storedCode = (string) ($verification['code'] ?? '');
        $expiresAt = (string) ($verification['expires_at'] ?? '');
        $attempts = (int) ($verification['attempts'] ?? 0);

        if ($expiresAt === '' || ! Time::parse($expiresAt)->isAfter(Time::now())) {
            session()->remove($sessionKey);
            return redirect()->to(base_url('ressources/download/request-code/' . $slug))
                ->with('error', 'Code expiré. Un nouveau code a été demandé.');
        }

        if (! hash_equals($storedCode, $code)) {
            $attempts++;
            $verification['attempts'] = $attempts;
            session()->set($sessionKey, $verification);

            if ($attempts >= 5) {
                session()->remove($sessionKey);
                return redirect()->to(base_url('ressources/download/request-code/' . $slug))
                    ->with('error', 'Trop de tentatives. Un nouveau code a été envoyé.');
            }

            return redirect()->back()->with('error', 'Code incorrect.')->withInput();
        }

        session()->set('download_verified_' . $resourceId, [
            'verified_at' => Time::now()->toDateTimeString(),
            'expires_at' => Time::now()->addMinutes(20)->toDateTimeString(),
        ]);
        session()->remove($sessionKey);

        return redirect()->to(base_url('ressources/download/' . $slug))
            ->with('success', 'Identité vérifiée. Téléchargement autorisé.');
    }

    public function checkout(string $slug)
    {
        if (! session()->has('user_id')) {
            return redirect()->to(base_url('connexion'))
                ->with('error', 'Connectez-vous pour acheter cette ressource premium.');
        }

        $userModel = new UserModel();
        $user = $userModel->find((int) session()->get('user_id'));

        if (! $user) {
            session()->destroy();
            return redirect()->to(base_url('connexion'))->with('error', 'Session invalide. Veuillez vous reconnecter.');
        }

        if (empty($user['is_active'])) {
            session()->set('pending_activation_email', (string) ($user['email'] ?? ''));
            return redirect()->to(base_url('compte-en-attente'))
                ->with('error', 'Votre compte doit être vérifié avant de finaliser un achat premium.');
        }

        $ressource = $this->model->getBySlug($slug);
        if (! $ressource || empty($ressource['is_premium'])) {
            throw PageNotFoundException::forPageNotFound();
        }

        $userResourceModel = new UserResourceModel();
        if ($userResourceModel->hasAccess((int) $user['id'], (int) $ressource['id'])) {
            return redirect()->to(base_url('ressources/' . $slug))
                ->with('success', 'Vous avez déjà accès à cette ressource.');
        }

        $promoCode = strtoupper(trim((string) ($this->request->getGet('promo') ?? '')));
        $promo = $this->resolvePromo($promoCode);
        $pricing = $this->computePricing((float) ($ressource['prix'] ?? 0), (float) ($promo['rate'] ?? 0));

        return $this->render('pages/checkout-ressource', [
            'page_title' => 'Finaliser mon achat — ' . ($ressource['titre'] ?? 'Ressource premium'),
            'page_description' => 'Validation de commande, code promo et paiement simulé.',
            'ressource' => $ressource,
            'checkoutUser' => $user,
            'promoCode' => $promoCode,
            'promo' => $promo,
            'pricing' => $pricing,
        ]);
    }

    public function checkoutSubmit(string $slug)
    {
        if (! session()->has('user_id')) {
            return redirect()->to(base_url('connexion'))
                ->with('error', 'Connectez-vous pour finaliser votre achat.');
        }

        $userModel = new UserModel();
        $user = $userModel->find((int) session()->get('user_id'));

        if (! $user || empty($user['is_active'])) {
            return redirect()->to(base_url('compte-en-attente'))
                ->with('error', 'Compte non vérifié. Veuillez vérifier votre compte avant l\'achat.');
        }

        $ressource = $this->model->getBySlug($slug);
        if (! $ressource || empty($ressource['is_premium'])) {
            throw PageNotFoundException::forPageNotFound();
        }

        $userResourceModel = new UserResourceModel();
        if ($userResourceModel->hasAccess((int) $user['id'], (int) $ressource['id'])) {
            return redirect()->to(base_url('ressources/' . $slug))
                ->with('success', 'Cette commande existe déjà pour votre compte.');
        }

        $action = (string) $this->request->getPost('action');
        $promoCode = strtoupper(trim((string) $this->request->getPost('promo_code')));
        $promo = $this->resolvePromo($promoCode);

        if ($action === 'apply_promo') {
            if ($promoCode === '') {
                return redirect()->back()->with('error', 'Entrez un code promo avant de cliquer sur Appliquer.')->withInput();
            }
            if (! empty($promo['error'])) {
                return redirect()->back()->with('error', $promo['error'])->withInput();
            }

            return redirect()->to(base_url('ressources/acheter/' . $slug . '?promo=' . rawurlencode($promoCode)))
                ->with('success', 'Code promo appliqué.');
        }

        $acceptTerms = (string) $this->request->getPost('accept_terms');
        $cardHolder = trim((string) $this->request->getPost('card_holder'));
        $cardNumber = preg_replace('/\D+/', '', (string) $this->request->getPost('card_number'));
        $cardExpiry = trim((string) $this->request->getPost('card_expiry'));
        $cardCvv = preg_replace('/\D+/', '', (string) $this->request->getPost('card_cvv'));

        if ($acceptTerms !== '1') {
            return redirect()->back()->with('error', 'Veuillez accepter les conditions avant de valider la commande.')->withInput();
        }
        if ($cardHolder === '' || strlen($cardHolder) < 3) {
            return redirect()->back()->with('error', 'Nom du titulaire invalide.')->withInput();
        }
        if (! preg_match('/^\d{16}$/', $cardNumber)) {
            return redirect()->back()->with('error', 'Numéro de carte invalide (16 chiffres requis).')->withInput();
        }
        if (! preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $cardExpiry)) {
            return redirect()->back()->with('error', 'Date d\'expiration invalide (MM/AA).')->withInput();
        }
        if (! preg_match('/^\d{3,4}$/', $cardCvv)) {
            return redirect()->back()->with('error', 'CVV invalide.')->withInput();
        }
        if (! empty($promo['error'])) {
            return redirect()->back()->with('error', $promo['error'])->withInput();
        }

        $db = \Config\Database::connect();
        if (! $db->tableExists('resource_orders')) {
            return redirect()->back()->with('error', 'Module de commande indisponible. Contactez l\'administrateur.')->withInput();
        }

        $pricing = $this->computePricing((float) ($ressource['prix'] ?? 0), (float) ($promo['rate'] ?? 0));
        $orderNumber = $this->generateOrderNumber();

        $orderModel = new ResourceOrderModel();
        $orderModel->insert([
            'user_id' => (int) $user['id'],
            'resource_id' => (int) $ressource['id'],
            'order_number' => $orderNumber,
            'base_amount' => (float) $pricing['base'],
            'discount_amount' => (float) $pricing['discount'],
            'total_amount' => (float) $pricing['total'],
            'currency' => 'TND',
            'promo_code' => $promoCode !== '' ? $promoCode : null,
            'payment_method' => 'simulation_online',
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'notes' => 'Paiement simulé en environnement ' . ENVIRONMENT,
        ]);

        $userResourceModel->grantAccess((int) $user['id'], (int) $ressource['id']);

        return redirect()->to(base_url('mon-compte/commandes'))
            ->with('success', 'Commande validée (' . $orderNumber . '). Paiement simulé accepté, accès activé.');
    }

    private function renderUnifiedResourcesPage(): string
    {
        $access = (string) ($this->request->getGet('access') ?? 'tous');
        $type = (string) ($this->request->getGet('type') ?? 'tous');
        $profil = (string) ($this->request->getGet('profil') ?? 'tous');

        $userResourceModel = new UserResourceModel();
        $userId = (int) (session()->get('user_id') ?? 0);
        $ownedResourceIds = $userId > 0
            ? $userResourceModel->getResourceIdsByUser($userId)
            : [];

        $builder = $this->model->orderBy('created_at', 'DESC');

        if ($access === 'gratuit') {
            $builder->where('is_premium', 0);
        } elseif ($access === 'premium') {
            $builder->where('is_premium', 1);
        }

        if ($type !== 'tous') {
            $builder->where('type', $type);
        }

        if ($profil !== 'tous') {
            $builder->where('profil', $profil);
        }

        $resources = $builder->findAll();

        return $this->render('pages/ressources', [
            'page_title'       => 'Ressources Gratuites et Premium — Yesmine Gharbi',
            'page_description' => 'Découvrez toutes les ressources: gratuites et premium, sur une seule page.',
            'resources'        => $resources,
            'ownedResourceIds' => $ownedResourceIds,
            'active_access'    => in_array($access, ['tous', 'gratuit', 'premium'], true) ? $access : 'tous',
            'active_type'      => $type,
            'active_profil'    => $profil,
        ]);
    }

    private function resolvePromo(string $code): array
    {
        if ($code === '') {
            return ['rate' => 0.0, 'error' => null, 'label' => null];
        }

        $catalog = [
            'BIENVENUE10' => 0.10,
            'VIP20' => 0.20,
            'SUMMER15' => 0.15,
        ];

        if (! array_key_exists($code, $catalog)) {
            return ['rate' => 0.0, 'error' => 'Code promo invalide.', 'label' => null];
        }

        $rate = (float) $catalog[$code];
        return ['rate' => $rate, 'error' => null, 'label' => '-' . (int) round($rate * 100) . '%'];
    }

    private function computePricing(float $baseAmount, float $discountRate): array
    {
        $base = max(0, round($baseAmount, 3));
        $discount = max(0, round($base * max(0, min(1, $discountRate)), 3));
        $total = max(0, round($base - $discount, 3));

        return [
            'base' => $base,
            'discount' => $discount,
            'total' => $total,
        ];
    }

    private function generateOrderNumber(): string
    {
        return 'CMD-' . date('YmdHis') . '-' . random_int(100, 999);
    }

    private function sendPremiumDownloadCode(int $resourceId, string $slug): bool
    {
        $user = session()->get('user') ?? [];
        $email = strtolower(trim((string) ($user['email'] ?? '')));
        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $code = (string) random_int(100000, 999999);
        $expiresAt = Time::now()->addMinutes(10)->toDateTimeString();

        session()->set('download_verification_' . $resourceId, [
            'code' => $code,
            'expires_at' => $expiresAt,
            'attempts' => 0,
            'slug' => $slug,
        ]);

        $emailService = service('email');
        $fromEmail = (string) env('email.fromEmail', 'hello@yesminegharbi.com');
        $fromName = (string) env('email.fromName', 'Yesmine Gharbi');

        $emailService->setFrom($fromEmail, $fromName);
        $emailService->setTo($email);
        $emailService->setSubject('Code de vérification de téléchargement');
        $emailService->setMessage(
            "Bonjour,\n\n" .
            "Votre code de vérification téléchargement est : " . $code . "\n" .
            "Ce code est valable 10 minutes.\n\n" .
            "Si vous n'êtes pas à l'origine de cette demande, ignorez cet email."
        );

        if (! $emailService->send()) {
            if (ENVIRONMENT === 'development') {
                session()->setFlashdata('success', 'Mode dev: code de téléchargement = ' . $code);
                return true;
            }
            return false;
        }

        return true;
    }

    private function isDownloadVerified(int $resourceId): bool
    {
        $key = 'download_verified_' . $resourceId;
        $verification = session()->get($key);

        if (! is_array($verification)) {
            return false;
        }

        $expiresAt = (string) ($verification['expires_at'] ?? '');
        if ($expiresAt === '' || ! Time::parse($expiresAt)->isAfter(Time::now())) {
            session()->remove($key);
            return false;
        }

        return true;
    }
}
