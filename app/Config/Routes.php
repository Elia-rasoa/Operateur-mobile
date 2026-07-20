<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');

$routes->post('/login/authentifier', 'Login::authentifier');
$routes->get('/login/logout', 'Login::logout');

// Redirection vers le futur espace client
$routes->get('/client/dashboard', 'ClientController::index');
$routes->get('/client/historique', 'ClientController::historique');

$routes->post('/client/transaction/depot', 'ClientController::depot');
$routes->post('/client/transaction/retrait', 'ClientController::retrait');
$routes->post('/client/transaction/transfert', 'ClientController::transfert');
$routes->get('/', 'Home::index');

// Routes Admin (hors groupe pour login/logout)
$routes->get('admin/login', 'Admin\AuthController::login');
$routes->post('admin/login/authentifier', 'Admin\AuthController::authenticate');
$routes->get('admin/logout', 'Admin\AuthController::logout');

$routes->group('admin', ['filter' => 'adminAuth'], static function ($routes) {
    // Dashboard
    $routes->get('/', 'Admin\DashboardController::index');

    // Module Barèmes
    $routes->get('baremes', 'Admin\BaremeController::index');
    $routes->post('baremes/add', 'Admin\BaremeController::add');
    $routes->post('baremes/update/(:num)', 'Admin\BaremeController::update/$1');
    $routes->post('baremes/delete/(:num)', 'Admin\BaremeController::delete/$1');

    // Module Préfixes
    $routes->get('prefixes', 'Admin\PrefixController::index');
    $routes->post('prefixes/add', 'Admin\PrefixController::add');
    $routes->post('prefixes/delete/(:num)', 'Admin\PrefixController::delete/$1');
    $routes->post('prefixes/operateur-courant', 'Admin\PrefixController::updateOperateurCourant');

    // Module Transactions (Reporting)
    $routes->get('transactions', 'Admin\TransactionController::index');

    // Nouveaux modules Version 2
    $routes->get('gains', 'Admin\GainController::index');
    $routes->get('reversement', 'Admin\ReversementController::index');

    // Module Clients
    $routes->get('clients', 'Admin\ClientController::index');
    $routes->get('clients/historique', static function () {
        return \redirect()->to('/admin/clients');
    });
    $routes->get('clients/historique/(:num)', 'Admin\ClientController::historique/$1');
});
