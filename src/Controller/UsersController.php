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

    /**
     * Register action
     */
    public function sign () {

        $user = null;

        if ($this->request->is('post')) {
            $regUser = TableRegistry::get('Users');
            $user = $regUser->newEntity($this->request->getData());

            if ($regUser->save($user)) {
                $this->Flash->success(__("Inscription terminée avec succès ! Vous pouvez dès à présent vous connecter."));
            } else {
                $this->Flash->error(__("Des champs ne sont pas valides, veuillez corriger les erreurs"));
            }
        }

        $cities = TableRegistry::get('Cities')->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->toArray();

        $cities = ['' => 'Ville'] + $cities;

        $this->set(compact('cities', 'user'));
    }

    /**
     * Sign in action /w 13 months cookie support
     * @return \Cake\Http\Response|null
     */
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
                $this->Flash->error(__('Aucun utiliateur ne correspond à ces identifiants.'));
            }
            return $this->redirect($this->referer());
        }
    }

    /**
     * Logout action (destroy auth session/cookie)
     */
    public function logout () {
        if ($this->request->is('post')) {
            TableRegistry::get('Tokens')->deleteAll([
                'name' => 'auth_token',
                'user_id' => $this->Auth->user('id')
            ]);
            $this->Cookie->delete('auth_token');
            $this->Auth->logout();
        } else {
            $this->redirect('/');
        }
    }

    /**
     * Password request action
     */
    public function forgot () {

    }

    /**
     * Password reset action
     * @param $token
     */
    public function reset ($token) {

    }
}
