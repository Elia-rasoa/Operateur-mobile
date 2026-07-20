<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', static function ($routes) {
    $routes->get('baremes', 'Admin\BaremeController::index');
    $routes->post('baremes/update/(:num)', 'Admin\BaremeController::update/$1');
});