<?php
namespace App\Controller\Admin;
use Cake\Mailer\Email;
use Cake\ORM\Query;
use Cake\Routing\Router;

class DishesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $dishes = $this->Dishes->find('queue')
            ->contain([
                'Restaurants' => function (Query $query) {
                    return $query->select(['Restaurants.name']);
                },
                'DishTypes' => function (Query $query) {
                    return $query->select(['DishTypes.name']);
                },
            ]);

        $this->paginate = ['limit' => 8];

        $this->set(['dishes' => $this->paginate($dishes)]);
        $this->set('_serialize', ['dishes']);
    }

    /**
     * Save method
     *
     * @param string|null $id Dish id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function save($id)
    {
        $rejected_dish = $this->Dishes->RejectedDishes->newEntity();
        $dish = $this->Dishes->find()
            ->where(['Dishes.id' => $id])
            ->contain([
                'Restaurants' => function (Query $query) {
                    return $query->select(['id', 'name', 'user_id']);
                },
                'Restaurants.Users' => function (Query $query) {
                    return $query->select(['email', 'firstname', 'lastname']);
                },
                'DishTypes',
                'RejectedDishes' => function (Query $query) {
                    return $query->orderDesc('RejectedDishes.created');
                }
            ])
            ->firstOrFail();

        if ($this->request->is(['patch', 'post', 'put'])) {

            $rejected_dish->dish_id = $dish->id;
            $rejected_dish = $this->Dishes->RejectedDishes->patchEntity($rejected_dish, $this->request->getData());

            if ($this->Dishes->RejectedDishes->save($rejected_dish)) {

                $email = new Email();
                $email->setLayout(null)
                    ->setTemplate('validate_dishes')
                    ->setEmailFormat('both')
                    ->setSubject("Refus de validation du plat {$dish->name}")
                    ->setTo($dish->restaurant->user->email, $dish->restaurant->user->fullname)
                    ->setViewVars([
                        'fullname' => $dish->restaurant->user->fullname,
                        'dish_name' => $dish->name,
                        'restaurant_name' => $dish->restaurant->name,
                        'reason' => $rejected_dish->content,
                        'link' => Router::url(['_name' => 'dishes:edit', 'resto' => $dish->restaurant->id, 'plat' => $dish->id], true)
                    ])
                    ->send();

                $this->Flash->success(__('Modération sauvegardée avec succès !'));

                return $this->redirect(['_name' => 'admin:dishes:index']);
            } else {
                $this->Flash->error(__('Une erreur s\'est produite lors de la soumission du formulaire'));
            }
        }

        $this->set(compact('dish', 'rejected_dish'));
        $this->set('_serialize', ['dish']);
    }

    /**
     * Valide un plat
     * @param $id - Identifiant du plat à valider
     * @return \Cake\Http\Response|null
     */
    public function validate ($id) {
        $this->request->allowMethod(['POST', 'PUT', 'PATCH']);

        if ($dish = $this->Dishes->get($id)) {
            $dish->active = true;
            if ($this->Dishes->save($dish)) {
                $this->Flash->success(__("Plat validé avec succès !"));
            } else {
                $this->Flash->error(__("Une erreur s'est produite lors de la validation du plat."));
            }
        }

        return $this->redirect($this->referer());
    }
}
