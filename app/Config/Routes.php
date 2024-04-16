<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
$routes->get('/', 'EvalformController::index');
$routes->get('/home', 'EvalformController::home');
$routes->get('/view-surveys', 'EvalformController::viewSurveys');
$routes->get('/edit-survey', 'EvalformController::createSurvey');
$routes->get('/admin', 'EvalformController::admin');
$routes->get('/login', 'EvalformController::login');
$routes->get('/register', 'EvalformController::register');
$routes->get('/landing', 'EvalformController::landing');

service('auth')->routes($routes);
