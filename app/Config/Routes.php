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

$routes->post('/client/transaction/depot', 'ClientController::depot');
$routes->post('/client/transaction/retrait', 'ClientController::retrait');
$routes->post('/client/transaction/transfert', 'ClientController::transfert');
