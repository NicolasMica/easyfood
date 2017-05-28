<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Dishes', 'action' => 'index'], ['_name' => 'plats']);

    $routes->connect('/villes', ['controller' => 'Cities', 'action' => 'index'], ['_name' => 'cities']);

    // ORDERS
    $routes->scope('/commande', ['_namePrefix' => 'orders:', 'controller' => 'Orders'], function (RouteBuilder $routes) {

        $routes->connect('/', ['action' => 'add', '_method' => 'POST'], ['_name' => 'add']);

        $routes->connect('/', ['action' => 'index', '_method' => 'GET'], ['_name' => 'index']);

        $routes->connect('/:id', ['action' => 'view'], [
            '_name' => 'view',
            'pass' => ['id'],
            'id' => '[0-9]+'
        ]);

    });

    // DISHES
    $routes->scope('/plats', ['_namePrefix' => 'dishes:', 'controller' => 'Dishes'], function (RouteBuilder $routes) {

        $routes->connect('/', ['action' => 'index'], ['_name' => 'index']);

        $routes->connect('/types', ['action' => 'types'], ['_name' => 'types']);

    });

    $routes->connect('/restaurants/:resto/plats/:plat/supprimer', ['controller' => 'Dishes', 'action' => 'delete'], [
        '_name' => 'dishes:delete',
        'pass' => ['resto', 'plat'],
        'resto' => '[0-9]+',
        'plat' => '[0-9]+'
    ]);

    $routes->connect('/restaurants/:resto/plats/:plat/modifier', ['controller' => 'Dishes', 'action' => 'save'], [
        '_name' => 'dishes:edit',
        'pass' => ['resto', 'plat'],
        'resto' => '[0-9]+',
        'plat' => '[0-9]+'
    ]);

    $routes->connect('/restaurants/:resto/plats/ajouter', ['controller' => 'Dishes', 'action' => 'save'], [
        '_name' => 'dishes:add',
        'pass' => ['resto'],
        'resto' => '[0-9]+'
    ]);

    // RESTAURANTS
    $routes->scope('/restaurants', ['_namePrefix' => 'resto:', 'controller' => 'Restaurants'], function (RouteBuilder $routes) {

        $routes->connect('/', ['action' => 'index'], ['_name' => 'index']);

        $routes->connect('/liste', ['action' => 'view'], ['_name' => 'view']);

        $routes->connect('/supprimer/:id', ['action' => 'delete'], [
            '_name' => 'delete',
            'pass' => ['id'],
            'id' => '[0-9]+'
        ]);

        $routes->connect('/modifier/:id', ['action' => 'save'], [
            '_name' => 'edit',
            'pass' => ['id'],
            'id' => '[0-9]+'
        ]);

        $routes->connect('/ajouter', ['action' => 'save'], ['_name' => 'add']);

    });

    // USERS
    $routes->scope('/utilisateurs', ['_namePrefix' => 'users:', 'controller' => 'Users'], function (RouteBuilder $routes) {

        $routes->connect('/authentification', ['action' => 'sign'], ['_name' => 'sign']);

        $routes->connect('/connexion', ['action' => 'login'], ['_name' => 'login', '_method' => 'POST']);

        $routes->connect('/inscription', ['action' => 'sign'], ['_name' => 'register', '_method' => 'POST']);

        $routes->connect('/deconnexion', ['action' => 'logout'], ['_name' => 'logout', '_method' => 'POST']);

        $routes->connect('/mot-de-passe-oublie', ['action' => 'forgot'], ['_name' => 'forgot']);

        $routes->connect('/reinitialiser/:token', ['action' => 'reset'], [
            '_name' => 'reset',
            'pass' => ['token']
        ]);

        $routes->connect('/preferences', ['action' => 'profile'], ['_name' => 'profile']);

        $routes->connect('/preferences/mot-de-passe', ['action' => 'password'], ['_name' => 'password']);

        $routes->connect('/preferences/suppression', ['action' => 'delete'], ['_name' => 'delete', '_method' => 'DELETE']);
    });

    // REVIEWS
    $routes->scope('/avis', ['_namePrefix' => 'reviews:', 'controller' => 'Reviews'], function (RouteBuilder $routes) {

        $routes->connect('/:order/rediger', ['action' => 'save'], [
                '_name' => 'save',
                '_method' => ['GET', 'POST', 'PUT', 'PATCH'],
                'pass' => ['order'],
                'order' => '[0-9]+'
            ]);

        $routes->connect('/:order', ['action' => 'view'], [
            '_name' => 'view',
            '_method' => ['GET', 'POST', 'PUT', 'PATCH'],
            'pass' => ['order'],
            'order' => '[0-9]+'
        ]);

    });

    $routes->prefix('admin', ['_namePrefix' => 'admin:'], function (RouteBuilder $routes) {

        $routes->connect('/cache', ['controller' => 'App', 'action' => 'cache'], [
            '_name' => 'app:cache',
            '_method' => 'DELETE'
        ]);

        $routes->connect('/avis', ['controller' => 'Reviews', 'action' => 'index'], [
            '_name' => 'reviews:index',
            '_method' => 'GET'
        ]);

        $routes->connect('/avis/:review', ['controller' => 'Reviews', 'action' => 'save'], [
            '_name' => 'reviews:save',
            '_method' => ['GET', 'POST', 'PUT', 'PATCH'],
            'pass' => ['review'],
            'review' => '[0-9]+'
        ]);

        $routes->connect('/avis/:review/valider', ['controller' => 'Reviews', 'action' => 'validate'], [
            '_name' => 'reviews:validate',
            '_method' => ['POST', 'PUT', 'PATCH'],
            'pass' => ['review'],
            'review' => '[0-9]+'
        ]);

        $routes->connect('/plats', ['controller' => 'Dishes', 'action' => 'index'], [
            '_name' => 'dishes:index',
            '_method' => 'GET'
        ]);

        $routes->connect('/plats/:dish', ['controller' => 'Dishes', 'action' => 'save'], [
            '_name' => 'dishes:save',
            '_method' => ['GET', 'POST', 'PUT', 'PATCH'],
            'pass' => ['dish'],
            'order' => '[0-9]+'
        ]);

        $routes->connect('/plats/:dish/valider', ['controller' => 'Dishes', 'action' => 'validate'], [
            '_name' => 'dishes:validate',
            '_method' => ['POST', 'PUT', 'PATCH'],
            'pass' => ['dish'],
            'dish' => '[0-9]+'
        ]);

    });

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
