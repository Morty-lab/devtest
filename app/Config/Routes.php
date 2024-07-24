<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('/', 'DashboardController::index');
 $routes->get('profile', 'DashboardController::profile');
 $routes->get('search', 'DashboardController::search');
 $routes->post('update', 'DashboardController::updateProfile');
 service('auth')->routes($routes);


