<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->group('back-panel', static function ($routes) {

    $routes->match(['get','post'], '/', 'AuthController::Auth');    
    $routes->group('/', ['filter'=>'authFilter','namespace' => 'App\Controllers'], static function ($routes) {
        $routes->get('dashboard', 'DashboardController::index');
        $routes->get('logout', 'AuthController::logout');
        $routes->match(['get','post'], 'update-profile', 'AuthController::updateProfile');
        $routes->match(['get','post'], 'change-password', 'AuthController::changePassword');
        // $routes->match(['get','post'], 'change-password', 'HomeController::Slider');

        $routes->match(['get', 'post'],'slider/', 'HomeController::Slider');
        $routes->match(['get', 'post'],'slider/(:segment)', 'HomeController::Slider/$1');
        $routes->match(['get', 'post'],'slider/(:segment)/(:segment)', 'HomeController::Slider/$1/$2');


        $routes->match(['get', 'post'],'documents/', 'HomeController::Documents');
        $routes->match(['get', 'post'],'documents/(:segment)', 'HomeController::Documents/$1');
        $routes->match(['get', 'post'],'documents/(:segment)/(:segment)', 'HomeController::Documents/$1/$2');


        $routes->match(['get', 'post'],'about-hospital/', 'HomeController::aboutHospital');
        $routes->match(['get', 'post'],'about-hospital/(:segment)', 'HomeController::aboutHospital/$1');
        $routes->match(['get', 'post'],'about-hospital/(:segment)/(:segment)', 'HomeController::aboutHospital/$1/$2');



        $routes->match(['get', 'post'],'gallery/', 'HomeController::Gallery');
        $routes->match(['get', 'post'],'gallery/(:segment)', 'HomeController::Gallery/$1');
        $routes->match(['get', 'post'],'gallery/(:segment)/(:segment)', 'HomeController::Gallery/$1/$2');
       
    });
});
/* $routes->group('back-panel', static function ($routes) {

    
    $routes->group('/', ['namespace' => 'App\Controllers'], static function ($routes) {
        $routes->get('dashboard', 'DashboardController::index');
       
    });
}); */
