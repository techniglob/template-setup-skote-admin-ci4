<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\MasterController;
use App\Controllers\ProductController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/get-file/(:any)', 'FileController::getFile/$1');
$routes->group('portal', static function ($routes) {

    $routes->match(['get', 'post'], '/', 'AuthController::Auth');
    $routes->group('/', ['namespace' => 'App\Controllers', 'filter' => 'authFilter'], static function ($routes) {
        $routes->get('dashboard', 'DashboardController::index');
        $routes->get('logout', 'AuthController::logout');
        $routes->match(['get', 'post'], 'update-profile', 'AuthController::updateProfile');
        $routes->match(['get', 'post'], 'change-password', 'AuthController::changePassword');
        // $routes->match(['get','post'], 'change-password', 'BackPanelController::Slider');

        $routes->match(['get', 'post'],'products/', [ProductController::class, 'products']);
        $routes->match(['get', 'post'],'products/(:segment)', [ProductController::class, 'products']);
        $routes->match(['get', 'post'],'products/(:segment)/(:segment)', [ProductController::class, 'products']);

        $routes->match(['get', 'post'],'categories/', [MasterController::class, 'categories']);
        $routes->match(['get', 'post'],'categories/(:segment)', [MasterController::class, 'categories']);
        $routes->match(['get', 'post'],'categories/(:segment)/(:segment)', [MasterController::class, 'categories']);


    });
});