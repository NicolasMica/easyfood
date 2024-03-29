<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Network\Exception\UnauthorizedException;
use Cake\ORM\TableRegistry;
use DateTime;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->loadComponent('Security');
        $this->loadComponent('Csrf');

        $this->loadComponent('Auth', [
            'loginAction' => [
                '_name' => 'users:sign'
            ],
            'loginRedirect' => [
              '_name' => 'users:profile'
            ],
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email', 'password' => 'password'],
                    'finder' => 'auth'
                ]
            ],
            'authError' => __("Vous devez être connecté pour accéder à cette page"),
        ]);

        $this->Cookie->configKey('auth_token', [
            'expires' => '+13 months',
            'httpOnly' => true
        ]);

        $this->Auth->deny();
    }

    /**
     * Méthode de callback exécutée avant les contrôleurs
     * Vérifie la présence du couple cookie/token pour la connexion automatique
     * @param Event $event
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        if ($this->Cookie->check('auth_token') && !$this->Auth->user()) {
            $token = TableRegistry::get('Tokens')->find('all')
                ->contain(['Users.Roles'])
                ->where([
                    'Tokens.name' => 'auth_token',
                    'Tokens.content' => $this->Cookie->read('auth_token'),
                    'Tokens.expires >' => new DateTime()
                ])->first();

            if ($token) {
                $this->Auth->setUser($token->user);
            } else {
                $this->Cookie->delete('auth_token');
            }
        }
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    /**
     * Vérifie si l'utilisateur courant à le niveau d'habilitation suffisant
     * @param $level - Authentication level
     */
    protected function authorize ($level) {
        if ($this->Auth->user('role.level') < $level) throw new UnauthorizedException();
    }
}
