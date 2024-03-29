<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Cache\Cache;
use Cake\I18n\Time;
use Cake\Mailer\Email;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
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
     * Inscription
     */
    public function sign () {
        if ($this->Auth->user()) return $this->redirect($this->Auth->redirectUrl());

        $user = null;

        if ($this->request->is('post')) {
            $regUser = TableRegistry::get('Users');
            $user = $regUser->newEntity($this->request->getData());

            $user->set('role_id', 4);

            if ($regUser->save($user)) {
                $this->Flash->success(__("Inscription terminée avec succès ! Vous êtes dès à présent vous connecter."));
                $this->Auth->setUser($user);
                $this->redirect(['_name' => 'users:profile']);
            } else {
                $this->Flash->error(__("Des champs ne sont pas valides, veuillez corriger les erreurs"));
            }
        }

        $cities = TableRegistry::get('Cities')->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])
            ->cache('cities')
            ->toArray();

        $cities = ['' => 'Ville'] + $cities;

        $this->set(compact('cities', 'user'));
    }

    /**
     * Connexion avec support cookie (13 mois)
     */
    public function login () {
        if ($this->Auth->user()) return $this->redirect($this->Auth->redirectUrl());

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
     * Déconnexion (suppression session & cookies)
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
        return $this->redirect('/');
    }

    /**
     * Demande de réinitialisation de mot de passe (envoi de mail)
     */
    public function forgot () {
        if ($this->Auth->user()) return $this->redirect($this->Auth->redirectUrl());

        $errors = null;

        if ($this->request->is('POST')) {

            $validator = new Validator();

            $validator
                ->notEmpty('email', __("Ce champ est obligatoire"))
                ->email('email', false, __("Ce champ doit contenir une adresse e-mail valide"));

            $errors = $validator->errors($this->request->getData());

            if (empty($errors)) {
                $userReg = TableRegistry::get('Users');
                $user = $userReg->find()->where(['email' => $this->request->getData('email')])->first();

                if ($user) {

                    $key = Security::hash($user->get('id') . '-' . uniqid() . '-' . time());

                    $regToken = TableRegistry::get('Tokens');
                    $token = $regToken->newEntity([
                        'name' => 'password_reset',
                        'content' => $key,
                        'expires' => new Time('+24 hours'),
                        'user_id' => $user->get('id')
                    ]);

                    $regToken->save($token);

                    $email = new Email();
                    $email->setLayout(null)
                        ->setTemplate('password')
                        ->setEmailFormat('both')
                        ->setSubject("Demande de réinitialisation de mot de passe")
                        ->setTo($user->get('email'), $user->get('fullname'))
                        ->setViewVars([
                            'link' => Router::url(['_name' => 'users:reset', 'token' => $key], true)
                        ])
                        ->send();

                    $this->Flash->success(__("E-mail de réinitialisation de mot de passe envoyé à l'adresse indiquée."));
                } else {
                    $this->Flash->error(__("Aucun compte ne correspond à cette adresse e-mail"));
                }
            }
        }

        $this->set(compact('errors'));
    }

    /**
     * Réinitialisation de mot de passe
     * @param $token string - Chaîne de caractère unique liée à l'utilisateur
     * @return \Cake\Http\Response|null
     */
    public function reset ($token) {
        if ($this->Auth->user()) return $this->redirect($this->Auth->redirectUrl());

        $tokenReg = TableRegistry::get('Tokens');
        $token = $tokenReg->find()->where(['content' => $token])->contain('Users')->first();

        if ($token === null) {
            $this->Flash->error(__("Le ticket de réinitialisation de mot de passe est invalide."));
            return $this->redirect('/');
        }

        $user = $token->get('user');

        if ($token->get('expires')->isPast()) {
            $tokenReg->delete($token);
            $this->Flash->warning(__("Le ticket de réinitialisation de mot de passe a éxpiré. Ce dernier vient donc d'être invalidé."));
            return $this->redirect('/');
        }

        if ($this->request->is(['POST', 'PUT'])) {
            $userReg = TableRegistry::get('Users');
            $userReg->patchEntity($user, $this->request->getData(), ['validate' => 'resetPassword']);
            if ($userReg->save($user)) {
                $tokenReg->deleteAll([
                    'name' => 'password_reset',
                    'user_id' => $user->get('id')
                ]);

                $this->Flash->success(__("Mot de passe réinitialiser avec succès ! Vous pouvez dès à présent vous connecter à l'aide de votre nouveau mot de passe."));

                $this->redirect(['_name' => 'users:sign']);
            } else {
                $this->Flash->error(__("Des champs ne sont pas valides, veuillez corriger les erreurs"));
            }
        }

        $this->set(compact('user'));
    }

    /**
     * Modification des informations personnelles
     */
    public function profile () {
        $user = TableRegistry::get('Users')->find()
            ->contain(['Roles'])
            ->where(['Users.id' => $this->Auth->user('id')])
            ->cache($this->Auth->user('id') . '-users')
            ->first();

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
            ])
            ->cache('cities')
            ->toArray();

        $orders = TableRegistry::get('Orders')->find()
            ->where(['Orders.user_id' => $this->Auth->user('id')])
            ->limit(10)
            ->contain([
                'Reviews' => function (Query $query) {
                    return $query->select(['id', 'active', 'order_id', 'restaurant_id', 'modified']);
                }
            ])
            ->cache($this->Auth->user('id') . '-last-orders')
            ->all();

        $this->set(compact('user', 'cities', 'pass', 'orders'));
    }

    /**
     * Modification du mot de passe
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
        return $this->redirect($this->referer());
    }

    /**
     * Suppression du compte
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

        return $this->redirect('/');
    }
}
