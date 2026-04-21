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
$routes->get('/panduan', 'Home::panduan', ['filter' => 'auth']);

$routes->group('guests', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Guests::index');
    $routes->get('duplicates', 'Guests::getDuplicates');
    $routes->post('store', 'Guests::store');
    $routes->post('update/(:num)', 'Guests::update/$1');
    $routes->get('delete/(:num)', 'Guests::delete/$1');
    $routes->get('import', 'Guests::import');
    $routes->post('import', 'Guests::processImport');
    $routes->get('print', 'Guests::printLabels');
    $routes->post('bulk-delete', 'Guests::bulkDelete');
    $routes->post('bulk-printed', 'Guests::bulkUpdatePrinted');
    $routes->post('printed/(:num)', 'Guests::updatePrinted/$1');
    $routes->post('toggle-selection/(:num)', 'Guests::toggleSelection/$1');
    $routes->post('bulk-toggle-selection', 'Guests::bulkToggleSelection');
    $routes->post('clear-selection', 'Guests::clearSelection');
});

$routes->group('events', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Events::index');
    $routes->post('store', 'Events::store');
    $routes->post('update/(:num)', 'Events::update/$1');
    $routes->get('delete/(:num)', 'Events::delete/$1');
});

$routes->group('users', ['filter' => ['auth', 'admin']], function($routes) {
    $routes->get('/', 'Users::index');
    $routes->post('store', 'Users::store');
    $routes->post('update/(:num)', 'Users::update/$1');
    $routes->get('delete/(:num)', 'Users::delete/$1');
});
