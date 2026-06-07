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
$routes->get('/ressources-gratuites',    'Ressources::gratuites',           ['as' => 'ressources-gratuites']);
$routes->get('/ressources-premium',      'Ressources::premium',             ['as' => 'ressources-premium']);
$routes->get('/ressources/(:segment)',   'Ressources::detail/$1',           ['as' => 'ressource-detail']);
$routes->get('/a-propos',                'Pages::apropos',                  ['as' => 'apropos']);
$routes->get('/entreprises',             'Pages::entreprises',              ['as' => 'entreprises']);
$routes->get('/contact',                 'Pages::contact',                  ['as' => 'contact']);
$routes->get('/confirmation',            'Pages::confirmation',             ['as' => 'confirmation']);

//--------------------------------------------------------------------
// API / FORMULAIRES (POST)
//--------------------------------------------------------------------
$routes->post('/api/newsletter',         'Api\Newsletter::subscribe',       ['as' => 'api-newsletter']);
$routes->post('/api/ressource-download', 'Api\Download::request',           ['as' => 'api-download']);
$routes->post('/api/contact',            'Api\Contact::send',               ['as' => 'api-contact']);

//--------------------------------------------------------------------
// ESPACE CLIENT
//--------------------------------------------------------------------
$routes->get('/mon-compte',              'Client\Dashboard::index',         ['as' => 'dashboard']);
$routes->get('/mon-compte/commandes',    'Client\Dashboard::commandes',     ['as' => 'commandes']);
$routes->get('/connexion',               'Auth::loginForm',                 ['as' => 'login']);
$routes->post('/connexion',              'Auth::login');
$routes->get('/deconnexion',             'Auth::logout',                    ['as' => 'logout']);
$routes->get('/inscription',             'Auth::registerForm',              ['as' => 'register']);
$routes->post('/inscription',            'Auth::register');
