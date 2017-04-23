<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;
use Cake\Validation\Validator;

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
        if ($this->Auth->user()) $this->Auth->redirectUrl();

        $user = null;

        if ($this->request->is('post')) {
            $regUser = TableRegistry::get('Users');
            $user = $regUser->newEntity($this->request->getData());

            $user->set('role_id', 4);

            if ($regUser->save($user)) {
                $this->Flash->success(__("Inscription terminée avec succès ! Vous pouvez dès à présent vous connecter."));
                $this->Auth->setUser($user);
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
        if ($this->Auth->user()) $this->Auth->redirectUrl();

        if ($this->request->is('post')) {

            $user = $this->Auth->identify();

            if ($user) {
                $this->Auth->setUser($user);

                // Handle cookies
                if ($this->request->getData('remember')) {
                    $key = Security::hash($this->Auth->user('id') . '-' . uniqid() . '-' . time());

                    $regToken = TableRegistry::get('Tokens');
                    $token = $regToken->newEntity([
                        'name' => 'auth_token',
                        'content' => $key,
                        'expires' => new Time('+13 months'),
                        'user_id' => $this->Auth->user('id')
                    ]);

                    $regToken->save($token);

                    $this->Cookie->write('auth_token', $key);
                }

                $this->Flash->success(__("Connecté avec succès !"));
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
        }
        $this->redirect('/');
    }

    /**
     * Password request action
     */
    public function forgot () {
        if ($this->Auth->user()) $this->Auth->redirectUrl();
    }

    /**
     * Password reset action
     * @param $token
     */
    public function reset ($token) {
        if ($this->Auth->user()) $this->Auth->redirectUrl();
    }

    /**
     * Profile action
     */
    public function profile () {
        $user = TableRegistry::get('Users')->get($this->Auth->user('id'));
        $pass = $this->request->session()->consume('formErrors');

        if ($this->request->is(['post', 'put']) && !empty($this->request->getData())) {
            $userReg = TableRegistry::get('Users');

            $profile = $userReg->patchEntity($user, $this->request->getData());

            if ($userReg->save($profile)) {
                $this->Flash->success(__("Préférences sauvegardées avec succès !"));
            } else {
                $this->Flash->error(__("Des champs ne sont pas valides, veuillez corriger les erreurs"));
            }
        }

        $cities = TableRegistry::get('Cities')->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->toArray();

//        $errors =

        $this->set(compact('user', 'cities', 'pass'));
    }

    /**
     * New password
     */
    public function password () {
        if ($this->request->is(['post', 'put'])) {
            $userReg = TableRegistry::get('Users');
            $user = $userReg->get($this->Auth->user('id'));
            $patch = $userReg->patchEntity($user, $this->request->getData(), ['validate' => 'password']);

            if($userReg->save($patch)) {
                $this->Flash->success(__("Mot de passe modifié avec succès !"));
            } else {
                $this->request->session()->write('formErrors', $patch);
                $this->Flash->error(__("Des champs ne sont pas valides, veuillez corriger les erreurs"));
            }
        }
        $this->redirect($this->referer());
    }

    /**
     * Account deletion action
     */
    public function delete () {
        if ($this->request->is('DELETE')) {
            $userReg = TableRegistry::get('Users');
            $user = $userReg->get($this->Auth->user('id'));
            if ($userReg->delete($user)) {
                TableRegistry::get('Tokens')->deleteAll([
                    'name' => 'auth_token',
                    'user_id' => $user->get('id')
                ]);
                $this->Cookie->delete('auth_token');
                $this->Auth->logout();

                $this->Flash->success(__("Compte supprimé avec succès !"));
            } else {
                $this->Flash->error(__("Une erreur s'est produite lors de la tentative de suppression de votre compte."));
            }
        }

        $this->redirect('/');
    }
}
