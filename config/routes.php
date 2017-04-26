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

    $routes->scope('/plats', ['_namePrefix' => 'dishes:', 'controller' => 'Dishes'], function (RouteBuilder $routes) {

        $routes->connect('/', ['action' => 'index'], ['_name' => 'index']);

        $routes->connect('/recherche', ['action' => 'search'], ['_name' => 'search']);

        $routes->connect('/types', ['action' => 'types'], ['_name' => 'types']);

    });


    $routes->scope('/restaurants', ['_namePrefix' => 'resto:', 'controller' => 'Restaurants'], function (RouteBuilder $routes) {

        $routes->connect('/', ['action' => 'index'], ['_name' => 'index']);

        $routes->connect('/:slug-:id', ['action' => 'view'], [
            '_name' => 'view',
            'pass' => ['slug', 'id'],
            'slug' => '[a-z0-9\-]+',
            'id' => '[0-9]+'
        ]);

    });

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
