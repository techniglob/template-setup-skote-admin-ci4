<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\AuthController;
use App\Controllers\ProfileController;
use App\Controllers\CommonController;
use App\Controllers\DashboardController;
use App\Controllers\MasterController;
use App\Controllers\ProductController;
/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/get-file/(:any)', [CommonController::class, 'getFile']);
$routes->get('/file', [CommonController::class, 'file']);
$routes->get('/session-flash', [CommonController::class, 'sessionFlash']);
$routes->group('portal', static function ($routes) {

    $routes->match(['get', 'post'], '/', [AuthController::class, 'auth']);


    $routes->group('/', ['namespace' => 'App\Controllers', 'filter' => 'authFilter'], static function ($routes) {
        $routes->get('dashboard', [DashboardController::class, 'index']);
        $routes->get('logout', 'AuthController::logout');
        $routes->match(['get', 'post'], 'update-profile', [ProfileController::class, 'updateProfile']);
        $routes->match(['get', 'post'], 'change-password', [ProfileController::class, 'changePassword']);

        $routes->match(['get', 'post'],'products/', [ProductController::class, 'products']);
        $routes->match(['get', 'post'],'products/(:segment)', [ProductController::class, 'products']);
        $routes->match(['get', 'post'],'products/(:segment)/(:segment)', [ProductController::class, 'products']);


    });
});