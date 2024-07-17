<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', function ($routes) {
    $routes->get('/', function () {
        return json_encode(['success' => true, 'message' => 'Seja bem vindo a API Lettiere!']);
    });
    $routes->post('login', 'AuthController::login', ['as' => 'login']);
    $routes->post('logout', 'AuthController::logout');
    $routes->get('user', 'AuthController::user');
    $routes->post('register', 'AuthController::register');

    $routes->group('courses', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {
        $routes->post('create', 'CourseController::create');
        $routes->put('update/(:num)', 'CourseController::update/$1');
        $routes->delete('delete/(:num)', 'CourseController::delete/$1');
        $routes->get('details/(:num)', 'CourseController::details/$1');
        $routes->get('list', 'CourseController::list');
    });

    $routes->group('teachers', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {
        $routes->post('create', 'TeacherController::create');
        $routes->put('update/(:num)', 'TeacherController::update/$1');
        $routes->delete('delete/(:num)', 'TeacherController::delete/$1');
        $routes->get('details/(:num)', 'TeacherController::details/$1');
        $routes->get('list', 'TeacherController::list');
    });

    $routes->group('guardians', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {
        $routes->post('create', 'GuardianController::create');
        $routes->put('update/(:num)', 'GuardianController::update/$1');
        $routes->delete('delete/(:num)', 'GuardianController::delete/$1');
        $routes->get('details/(:num)', 'GuardianController::details/$1');
        $routes->get('list', 'GuardianController::list');
    });

    $routes->group('classes', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {
        $routes->post('create', 'ClassController::create');
        $routes->put('update/(:num)', 'ClassController::update/$1');
        $routes->delete('delete/(:num)', 'ClassController::delete/$1');
        $routes->get('details/(:num)', 'ClassController::details/$1');
        $routes->get('list', 'ClassController::list');
    });

    $routes->group('students', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {
        $routes->post('create', 'StudentController::create');
        $routes->put('update/(:num)', 'StudentController::update/$1');
        $routes->delete('delete/(:num)', 'StudentController::delete/$1');
        $routes->get('details/(:num)', 'StudentController::details/$1');
        $routes->get('list', 'StudentController::list');
    });

    $routes->group('users', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {
        $routes->put('update/(:num)', 'UserController::update/$1');
        $routes->delete('delete/(:num)', 'UserController::delete/$1');
        $routes->get('details/(:num)', 'UserController::details/$1');
        $routes->get('list', 'UserController::list');
    });
});
