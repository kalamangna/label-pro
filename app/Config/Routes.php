<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'Home::dashboard');

$routes->group('recipients', function($routes) {
    $routes->get('/', 'Recipients::index');
    $routes->get('create', 'Recipients::create');
    $routes->post('store', 'Recipients::store');
    $routes->get('edit/(:num)', 'Recipients::edit/$1');
    $routes->post('update/(:num)', 'Recipients::update/$1');
    $routes->get('delete/(:num)', 'Recipients::delete/$1');
    $routes->get('import', 'Recipients::import');
    $routes->post('import', 'Recipients::processImport');
    $routes->get('print', 'Recipients::printLabels');
    $routes->get('export-pdf', 'Recipients::exportPdf');
    $routes->post('select/(:num)', 'Recipients::updateSelected/$1');
    $routes->post('bulk-select', 'Recipients::bulkUpdateSelected');
    $routes->post('printed/(:num)', 'Recipients::updatePrinted/$1');
});
