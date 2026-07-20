<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('admin', 'Admin\DashboardController::index');

$routes->group('admin', static function ($routes) {
    // Module Barèmes
    $routes->get('baremes', 'Admin\BaremeController::index');
    $routes->post('baremes/add', 'Admin\BaremeController::add');
    $routes->post('baremes/update/(:num)', 'Admin\BaremeController::update/$1');
    $routes->post('baremes/delete/(:num)', 'Admin\BaremeController::delete/$1');

    // Module Préfixes
    $routes->get('prefixes', 'Admin\PrefixController::index');
    $routes->post('prefixes/add', 'Admin\PrefixController::add');
    $routes->post('prefixes/delete/(:num)', 'Admin\PrefixController::delete/$1');

    // Module Transactions (Reporting)
    $routes->get('transactions', 'Admin\TransactionController::index');

    // Module Clients
    $routes->get('clients', 'Admin\ClientController::index');
    $routes->get('clients/historique/(:num)', 'Admin\ClientController::historique/$1');
});
