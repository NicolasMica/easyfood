<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin('Inspirat/Authenticate', ['path' => '/auth', '_namePrefix' => 'auth:'], function (RouteBuilder $routes) {

    $routes->connect('/login', ['controller' => 'Authenticate', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Authenticate', 'action' => 'logout']);
    $routes->connect('/register', ['controller' => 'Authenticate', 'action' => 'register']);
    $routes->connect('/forgot', ['controller' => 'Authenticate', 'action' => 'forgot']);
    $routes->connect('/reset/:token', ['controller' => 'Authenticate', 'action' => 'reset'], ['pass' => ['token']]);

    $routes->fallbacks(DashedRoute::class);
});
