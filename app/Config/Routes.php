<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\AuthController;
use App\Controllers\ProfileController;
use App\Controllers\CommonController;
use App\Controllers\DashboardController;
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


    });
});