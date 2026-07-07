<?php

use CodeIgniter\Router\RouteCollection;

/**
 * Routes — yesminegharbi.com
 *
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

//--------------------------------------------------------------------
// PAGES PUBLIQUES
//--------------------------------------------------------------------
$routes->get('/',                        'Home::index',                    ['as' => 'home']);
$routes->get('/formations',              'Formations::index',               ['as' => 'formations']);
$routes->get('/formations/(:segment)',   'Formations::detail/$1',           ['as' => 'formation-detail']);
$routes->get('/ressources',              'Ressources::index',               ['as' => 'ressources']);
$routes->get('/ressources-gratuites',    'Ressources::gratuites',           ['as' => 'ressources-gratuites']);
$routes->get('/ressources-premium',      'Ressources::premium',             ['as' => 'ressources-premium']);
$routes->get('/ressources/acheter/(:segment)', 'Ressources::checkout/$1',   ['as' => 'ressource-checkout']);
$routes->post('/ressources/acheter/(:segment)', 'Ressources::checkoutSubmit/$1', ['as' => 'ressource-checkout-submit']);
$routes->get('/ressources/download/request-code/(:segment)', 'Ressources::requestDownloadCode/$1', ['as' => 'ressource-download-request-code']);
$routes->get('/ressources/download/verification/(:segment)', 'Ressources::downloadVerificationForm/$1', ['as' => 'ressource-download-verification']);
$routes->post('/ressources/download/verification/(:segment)', 'Ressources::verifyDownloadCode/$1', ['as' => 'ressource-download-verification-submit']);
$routes->get('/ressources/download/(:segment)', 'Ressources::download/$1', ['as' => 'ressource-download']);
$routes->get('/ressources/(:segment)',   'Ressources::detail/$1',           ['as' => 'ressource-detail']);
$routes->get('/a-propos',                'Pages::apropos',                  ['as' => 'apropos']);
$routes->get('/entreprises',             'Pages::entreprises',              ['as' => 'entreprises']);
$routes->get('/contact',                 'Pages::contact',                  ['as' => 'contact']);
$routes->get('/confirmation',            'Pages::confirmation',             ['as' => 'confirmation']);
$routes->get('/activation/(:num)/(:segment)', 'Activation::activate/$1/$2', ['as' => 'activation']);

//--------------------------------------------------------------------
// API / FORMULAIRES (POST)
//--------------------------------------------------------------------
$routes->post('/api/newsletter',         'Api\Newsletter::subscribe',       ['as' => 'api-newsletter']);
$routes->post('/api/ressource-download', 'Api\Download::request',           ['as' => 'api-download']);
$routes->post('/api/ressource-access',   'Api\RessourceAccess::claim',     ['as' => 'api-resource-access']);
$routes->post('/api/account/resend-activation', 'Api\AccountActivation::resend', ['as' => 'api-account-resend']);
$routes->post('/api/contact',            'Api\Contact::send',               ['as' => 'api-contact']);

//--------------------------------------------------------------------
// ESPACE CLIENT
//--------------------------------------------------------------------
$routes->get('/mon-compte',              'Client\Dashboard::index',         ['as' => 'dashboard']);
$routes->get('/mon-compte/commandes',    'Client\Dashboard::commandes',     ['as' => 'commandes']);
$routes->post('/mon-compte/profil',      'Client\Dashboard::updateProfile', ['as' => 'dashboard-profile-update']);
$routes->post('/mon-compte/mot-de-passe','Client\Dashboard::updatePassword',['as' => 'dashboard-password-update']);
$routes->get('/connexion',               'Auth::loginForm',                 ['as' => 'login']);
$routes->post('/connexion',              'Auth::login');
$routes->get('/auth/google',             'Auth::googleRedirect',            ['as' => 'google-login']);
$routes->get('/auth/google/callback',    'Auth::googleCallback',            ['as' => 'google-callback']);
$routes->get('/compte-en-attente',       'Auth::pendingActivation',        ['as' => 'pending-activation']);
$routes->get('/verification-compte',     'Auth::verificationForm',         ['as' => 'account-verification']);
$routes->post('/verification-compte',    'Auth::verifyCode',               ['as' => 'account-verification-submit']);
$routes->get('/finaliser-compte',        'Auth::completeRegistrationForm', ['as' => 'account-complete']);
$routes->post('/finaliser-compte',       'Auth::completeRegistration',     ['as' => 'account-complete-submit']);
$routes->get('/mot-de-passe-oublie',     'Auth::forgotPassword',           ['as' => 'forgot-password']);
$routes->post('/mot-de-passe-oublie',    'Auth::sendResetLink',            ['as' => 'forgot-password-submit']);
$routes->get('/reinitialiser-mot-de-passe/(:num)/(:segment)', 'Auth::resetPasswordForm/$1/$2', ['as' => 'reset-password-form']);
$routes->post('/reinitialiser-mot-de-passe/(:num)/(:segment)', 'Auth::resetPassword/$1/$2', ['as' => 'reset-password-submit']);
$routes->get('/deconnexion',             'Auth::logout',                    ['as' => 'logout']);
$routes->get('/inscription',             'Auth::registerForm',              ['as' => 'register']);
$routes->post('/inscription',            'Auth::register');

//--------------------------------------------------------------------
// ADMIN
//--------------------------------------------------------------------
$routes->get('/admin/login',             'Admin\Auth::loginForm',           ['as' => 'admin-login']);
$routes->post('/admin/login',            'Admin\Auth::login');
$routes->get('/admin/logout',            'Admin\Auth::logout',              ['as' => 'admin-logout']);

$routes->group('admin', ['filter' => 'adminauth', 'namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('/',                    'Dashboard::index',                ['as' => 'admin-dashboard']);

    // Formations
    $routes->get('formations',                        'Formations::index',              ['as' => 'admin-formations']);
    $routes->get('formations/new',                    'Formations::create',             ['as' => 'admin-formation-new']);
    $routes->post('formations/store',                 'Formations::store',              ['as' => 'admin-formation-store']);
    $routes->get('formations/(:num)',                 'Formations::detail/$1',          ['as' => 'admin-formation-detail']);
    $routes->get('formations/(:num)/edit',            'Formations::edit/$1',            ['as' => 'admin-formation-edit']);
    $routes->post('formations/(:num)/update',         'Formations::update/$1',          ['as' => 'admin-formation-update']);
    $routes->post('formations/(:num)/delete',         'Formations::delete/$1',          ['as' => 'admin-formation-delete']);
    // Modules
    $routes->post('formations/(:num)/modules/store',  'Formations::storeModule/$1',     ['as' => 'admin-module-store']);
    $routes->post('modules/(:num)/update',            'Formations::updateModule/$1',    ['as' => 'admin-module-update']);
    $routes->post('modules/(:num)/delete',            'Formations::deleteModule/$1',    ['as' => 'admin-module-delete']);
    // Lecons
    $routes->post('modules/(:num)/lecons/store',      'Formations::storeLecon/$1',      ['as' => 'admin-lecon-store']);
    $routes->post('lecons/(:num)/update',             'Formations::updateLecon/$1',     ['as' => 'admin-lecon-update']);
    $routes->post('lecons/(:num)/delete',             'Formations::deleteLecon/$1',     ['as' => 'admin-lecon-delete']);

    // Ressources
    $routes->get('ressources',           'Ressources::index',               ['as' => 'admin-ressources']);
    $routes->get('ressources/new',       'Ressources::create',              ['as' => 'admin-ressource-new']);
    $routes->post('ressources/store',    'Ressources::store',               ['as' => 'admin-ressource-store']);
    $routes->get('ressources/(:num)/edit','Ressources::edit/$1',            ['as' => 'admin-ressource-edit']);
    $routes->post('ressources/(:num)/update','Ressources::update/$1',       ['as' => 'admin-ressource-update']);
    $routes->post('ressources/(:num)/delete','Ressources::delete/$1',       ['as' => 'admin-ressource-delete']);

    // Newsletter & Messages
    $routes->get('newsletter',           'Newsletter::index',               ['as' => 'admin-newsletter']);
    $routes->post('newsletter/(:num)/delete','Newsletter::delete/$1',       ['as' => 'admin-newsletter-delete']);
    $routes->get('messages',             'Messages::index',                 ['as' => 'admin-messages']);
    $routes->post('messages/(:num)/delete','Messages::delete/$1',           ['as' => 'admin-message-delete']);

    // Paramètres
    $routes->get('parametres',           'Parametres::index',               ['as' => 'admin-parametres']);
    $routes->post('parametres/update',   'Parametres::update',              ['as' => 'admin-parametres-update']);

    // Utilisateurs
    $routes->get('users',                'Users::index',                    ['as' => 'admin-users']);
    $routes->post('users/(:num)/toggle', 'Users::toggleStatus/$1',         ['as' => 'admin-user-toggle']);

    // Connexions sociales
    $routes->get('socials',              'Socials::index',                  ['as' => 'admin-socials']);
    $routes->post('socials/update',      'Socials::update',                 ['as' => 'admin-socials-update']);

    // Témoignages
    $routes->get('testimonials',         'Testimonials::index',             ['as' => 'admin-testimonials']);
    $routes->get('testimonials/new',     'Testimonials::create',            ['as' => 'admin-testimonial-new']);
    $routes->post('testimonials/store',  'Testimonials::store',             ['as' => 'admin-testimonial-store']);
    $routes->get('testimonials/(:num)/edit','Testimonials::edit/$1',          ['as' => 'admin-testimonial-edit']);
    $routes->post('testimonials/(:num)/update','Testimonials::update/$1',      ['as' => 'admin-testimonial-update']);
    $routes->post('testimonials/(:num)/delete','Testimonials::delete/$1',      ['as' => 'admin-testimonial-delete']);
});
