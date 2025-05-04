<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/get-file/(:any)', 'FileController::getFile/$1');
$routes->get('avatar/(:any)', 'FileController::show/$1');
$routes->group('portal', static function ($routes) {

    $routes->match(['get', 'post'], '/', 'AuthController::Auth');
    $routes->group('/', ['namespace' => 'App\Controllers', 'filter' => 'authFilter'], static function ($routes) {
        $routes->get('dashboard', 'DashboardController::index');
        $routes->get('logout', 'AuthController::logout');
        $routes->match(['get', 'post'], 'update-profile', 'AuthController::updateProfile');
        $routes->match(['get', 'post'], 'change-password', 'AuthController::changePassword');
        // $routes->match(['get','post'], 'change-password', 'BackPanelController::Slider');


    });
});