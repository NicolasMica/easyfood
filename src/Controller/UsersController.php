<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['sign', 'login', 'register', 'forgot', 'reset']);
    }

    public function sign () {
        $this->loadModel('Cities');

        $cities = $this->Cities->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->toArray();

        $cities = ['' => 'Ville'] + $cities;

        $this->set(compact('cities'));
    }

    public function login () {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);

                // Gestion des cookies
                if ($this->request->getParam('remember')) {
                    $key = Security::randomBytes(128);
                    $regToken = TableRegistry::get('Tokens');
                    $token = $regToken->newEntity([
                        'name' => 'auth_token',
                        'content' => $key
                    ]);

                    $regToken->save($token);

                    $this->Cookie->write('auth_token', $key);
                }

                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('Les identifiants sont incorrectes'));
            }
            return $this->redirect($this->referer());
        }
    }

    public function logout () {
        TableRegistry::get('Tokens')->deleteAll([
            'name' => 'auth_token',
            'user_id' => $this->Auth->user('id')
        ]);
        $this->Cookie->delete('auth_token');
        $this->Auth->logout();
    }

    public function register () {
        $regUser = TableRegistry::get('Users');
        $user = $regUser->newEntity($this->request->getData());
        // TODO: validation
    }

    public function forgot () {

    }

    public function reset ($token) {

    }
}
