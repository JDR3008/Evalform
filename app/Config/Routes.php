<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'EvalformController::index');
$routes->get('/view-surveys', 'EvalformController::viewSurveys');
$routes->get('/edit-survey', 'EvalformController::createSurvey');
$routes->get('/login', 'EvalformController::login');
$routes->get('/register', 'EvalformController::register');
// $routes->post('admin/(:num)', 'EvalformController::addedit/$1');

$routes->group('admin', function($routes) {
    $routes->get('/', 'EvalformController::admin');
    $routes->post('changeStatus/(:num)', 'EvalformController::changeStatus/$1');
    $routes->post('add', 'EvalformController::adduser');
    $routes->post('edit', 'EvalformController::edituser');
    // $routes->match(['get', 'post'], 'addedit', 'EvalformController::addedit');
    // $routes->match(['get', 'post'], 'addedit/(:num)', 'EvalformController::addedit/$1');
});

service('auth')->routes($routes);
