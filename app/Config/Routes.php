<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Index page
$routes->get('/', 'EvalformController::index');

// Login and Register Pages
$routes->get('/login', 'EvalformController::login');
$routes->get('/register', 'EvalformController::register');

// This route is what the respondent uses after they scan the QR code
$routes->get('/respondent-survey/(:num)', 'EvalformController::respondentSurvey/$1');

// If the respondent clicks on submit responses
$routes->post('/respondent-survey/(:num)/submitResponses','EvalformController::submitResponses/$1');


// View Surveys Page

// main returned view for view surveys. Users will see this page.
$routes->get('/view-surveys', 'EvalformController::viewSurveys');

// Delete survey post request
$routes->post('/view-surveys/deleteSurvey','EvalformController::deleteSurvey');

// Change survey title post request
$routes->post('/view-surveys/changeSurveyTitle','EvalformController::changeSurveyTitle');

// Create new survey post request
$routes->post('view-surveys/createSurvey','EvalformController::createSurvey');

// View specific survey. This get request happens if the user clicks "View Survey"
$routes->get('view-surveys/(:num)', 'EvalformController::viewSurvey/$1');


// View Specific Survey Page

// QR code get request
$routes->get('view-surveys/(:num)/qrcode','EvalformController::getQRCodes/$1');

// Edit survey get request
$routes->get('view-surveys/(:num)/edit-survey', 'EvalformController::editSurvey/$1');


// Edit Survey Page

// Add question post request
$routes->post('view-surveys/(:num)/edit-survey/addQuestion', 'EvalformController::addQuestion/$1');

// Delete question post request
$routes->post('view-surveys/(:num)/edit-survey/deleteQuestion', 'EvalformController::deleteQuestion/$1');


// View Responses Page

// Main get request for the viewing of responses page
$routes->get('view-surveys/responses/(:num)','EvalformController::viewResponses/$1');

// Export responses post request
$routes->post('view-surveys/responses/(:num)/export','EvalformController::exportResponses/$1');


// Admin Page
$routes->group('admin', function($routes) {
    // Main get request for admin page
    $routes->get('/', 'EvalformController::admin');
    // Change status of user post request
    $routes->post('changeStatus/(:num)', 'EvalformController::changeStatus/$1');
    // Add user post request
    $routes->post('add', 'EvalformController::adduser');
    // Edit user post request
    $routes->post('edit', 'EvalformController::edituser');
});

service('auth')->routes($routes);
