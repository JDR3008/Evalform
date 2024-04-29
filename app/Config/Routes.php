<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'EvalformController::index');

$routes->get('/login', 'EvalformController::login');
$routes->get('/register', 'EvalformController::register');

$routes->get('/edit-survey', 'EvalformController::createSurvey');


$routes->get('/view-surveys', 'EvalformController::viewSurveys');
$routes->post('/view-surveys/deleteSurvey/(:num)','EvalformController::deleteSurvey/$1');
$routes->post('/view-surveys/changeSurveyTitle','EvalformController::changeSurveyTitle');
$routes->get('view-surveys/(:num)', 'EvalformController::viewSurvey/$1');

$routes->group('admin', function($routes) {
    $routes->get('/', 'EvalformController::admin');
    $routes->post('changeStatus/(:num)', 'EvalformController::changeStatus/$1');
    $routes->post('add', 'EvalformController::adduser');
    $routes->post('edit', 'EvalformController::edituser');
});

service('auth')->routes($routes);
