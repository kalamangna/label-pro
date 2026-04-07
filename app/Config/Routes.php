<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/demo/start', 'AuthController::startDemo');

$routes->get('/dashboard', 'Home::dashboard', ['filter' => 'auth']);

$routes->group('recipients', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Recipients::index');
    $routes->post('store', 'Recipients::store');
    $routes->post('update/(:num)', 'Recipients::update/$1');
    $routes->get('delete/(:num)', 'Recipients::delete/$1');
    $routes->get('import', 'Recipients::import');
    $routes->post('import', 'Recipients::processImport');
    $routes->get('print', 'Recipients::printLabels');
    $routes->get('export-pdf', 'Recipients::exportPdf');
    $routes->post('select/(:num)', 'Recipients::updateSelected/$1');
    $routes->post('bulk-select', 'Recipients::bulkUpdateSelected');
    $routes->post('bulk-delete', 'Recipients::bulkDelete');
    $routes->post('bulk-printed', 'Recipients::bulkUpdatePrinted');
    $routes->post('printed/(:num)', 'Recipients::updatePrinted/$1');
});

$routes->group('users', ['filter' => ['auth', 'admin']], function($routes) {
    $routes->get('/', 'Users::index');
    $routes->post('store', 'Users::store');
    $routes->post('update/(:num)', 'Users::update/$1');
    $routes->get('delete/(:num)', 'Users::delete/$1');
});
