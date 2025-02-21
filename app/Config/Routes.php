<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->group('portal', static function ($routes) {

    $routes->match(['get', 'post'], '/', 'AuthController::Auth');
    $routes->group('/', ['filter' => 'authFilter', 'namespace' => 'App\Controllers'], static function ($routes) {
        $routes->get('dashboard', 'DashboardController::index');
        $routes->get('logout', 'AuthController::logout');
        $routes->match(['get', 'post'], 'update-profile', 'AuthController::updateProfile');
        $routes->match(['get', 'post'], 'change-password', 'AuthController::changePassword');
        // $routes->match(['get','post'], 'change-password', 'BackPanelController::Slider');

        $routes->match(['get', 'post'], 'courses/', 'BackPanelController::courses');
        $routes->match(['get', 'post'], 'courses/(:segment)', 'BackPanelController::courses/$1');
        $routes->match(['get', 'post'], 'courses/(:segment)/(:segment)', 'BackPanelController::courses/$1/$2');

        $routes->match(['get', 'post'], 'course-categories/', 'BackPanelController::courseCategory');
        $routes->match(['get', 'post'], 'course-categories/(:segment)', 'BackPanelController::courseCategory/$1');
        $routes->match(['get', 'post'], 'course-categories/(:segment)/(:segment)', 'BackPanelController::courseCategory/$1/$2');

        $routes->match(['get', 'post'], 'course-videos/', 'BackPanelController::courseVideo');
        $routes->match(['get', 'post'], 'course-videos/(:segment)', 'BackPanelController::courseVideo/$1');
        $routes->match(['get', 'post'], 'course-videos/(:segment)/(:segment)', 'BackPanelController::courseVideo/$1/$2');


        $routes->match(['get', 'post'], 'sliders/', 'BackPanelController::sliders');
        $routes->match(['get', 'post'], 'sliders/(:segment)', 'BackPanelController::sliders/$1');
        $routes->match(['get', 'post'], 'sliders/(:segment)/(:segment)', 'BackPanelController::sliders/$1/$2');

        $routes->match(['get', 'post'], 'services/', 'BackPanelController::services');
        $routes->match(['get', 'post'], 'services/(:segment)', 'BackPanelController::services/$1');
        $routes->match(['get', 'post'], 'services/(:segment)/(:segment)', 'BackPanelController::services/$1/$2');

        $routes->match(['get', 'post'], 'plans/', 'BackPanelController::plans');
        $routes->match(['get', 'post'], 'plans/(:segment)', 'BackPanelController::plans/$1');
        $routes->match(['get', 'post'], 'plans/(:segment)/(:segment)', 'BackPanelController::plans/$1/$2');
        $routes->match(['get', 'post'], 'unique-validate-video-type-course-wise', 'BackPanelController::uniqueValidationVideoTypeCourseWise');

        $routes->match(['get', 'post'], 'customers/', 'BackPanelController::customers');
        $routes->match(['get', 'post'], 'customers/(:segment)', 'BackPanelController::customers/$1');
        $routes->match(['get', 'post'], 'customers/(:segment)/(:segment)', 'BackPanelController::customers/$1/$2');


        $routes->match(['get', 'post'], 'customer-courses/(:segment)', 'BackPanelController::customerCourses/$1');
        $routes->match(['get', 'post'], 'customer-courses/(:segment)', 'BackPanelController::customerCourses/$1');
        $routes->match(['get', 'post'], 'customer-courses/(:segment)/(:segment)', 'BackPanelController::customerCourses/$1/$2');

        $routes->match(['get', 'post'], 'customer-subscriptions/(:segment)', 'BackPanelController::customerSubscriptions/$1');
        $routes->match(['get', 'post'], 'customer-subscriptions/(:segment)', 'BackPanelController::customerSubscriptions/$1');
        $routes->match(['get', 'post'], 'customer-subscriptions/(:segment)/(:segment)', 'BackPanelController::customerSubscriptions/$1/$2');


        $routes->match(['get', 'post'], 'settings/', 'BackPanelController::settings');
        $routes->match(['get', 'post'], 'settings/(:segment)', 'BackPanelController::settings/$1');
        $routes->match(['get', 'post'], 'settings/(:segment)/(:segment)', 'BackPanelController::settings/$1/$2');


        $routes->match(['get', 'post'], 'appointments/', 'BackPanelController::appointments');
        $routes->match(['get', 'post'], 'appointments/(:segment)', 'BackPanelController::appointments/$1');
        $routes->match(['get', 'post'], 'appointments/(:segment)/(:segment)', 'BackPanelController::appointments/$1/$2');


        $routes->match(['get', 'post'], 'contacts/', 'BackPanelController::contacts');
        $routes->match(['get', 'post'], 'contacts/(:segment)', 'BackPanelController::contacts/$1');
        $routes->match(['get', 'post'], 'contacts/(:segment)/(:segment)', 'BackPanelController::contacts/$1/$2');

        $routes->get('/settings/get-field-by-type/(:segment)', 'Settings::getFieldByType/$1');

    });
});