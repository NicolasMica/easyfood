<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Cache\Cache;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

/**
 * Dishes Controller
 *
 * @property \App\Model\Table\DishesTable $Dishes
 */
class DishesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['index', 'types']);
    }

    /**
     * Liste des plats avec leur restaurant & type de plat associé
     * Le résultat de la requête est mis en cache
     * @return \Cake\Network\Response|null
     */
    public function index () {
        $query = $this->Dishes->find('published');
        $dishes = $query->contain([
                'DishTypes' => function (Query $q) {
                    return $q->enableAutoFields();
                },
                'Restaurants' => function (Query $q) {
                    return $q->select(['id', 'name', 'city_id']);
                },
                'Restaurants.Reviews' => function (Query $q) use ($query) {
                    return $q->select([
                            'quality' => $query->func()->avg('quality'),
                            'recipe' => $query->func()->avg('recipe'),
                            'design' => $query->func()->avg('design'),
                            'price' => $query->func()->avg('price'),
                            'restaurant_id'
                        ])
                        ->where(['active' => true]);
                }
            ])
            ->cache('dishes')
            ->all();

        $this->set(compact('dishes'));
        $this->set('_serialize', ['dishes']);
    }

    /**
     * Liste des types de plat ayant au moins un plat associé
     * Le résultat de la requête est mis en cache
     */
    public function types () {
        $dishTypes = TableRegistry::get('DishTypes')->find()
            ->select(['id', 'name'])
            ->distinct('DishTypes.id')
            ->matching('Dishes', function (Query $q) {
                return $q->where(['Dishes.active' => true]);
            })
            ->cache('dish_types')
            ->all();

        $this->set(compact('dishTypes'));
        $this->set('_serialize', ['dishTypes']);
    }

    /**
     * Création ou modification d'un plat du restaurant
     * @param $resto - Identifiant du restaurant
     * @param null $id - Identifiant du plat s'il s'agit d'une modification
     * @return \Cake\Http\Response|null
     */
    public function save ($resto, $id = null) {

        if ($id === null) {
            $dish = $this->Dishes->newEntity();
            $dish->restaurant_id = $resto;
            $dish->active = false;
        } else {
            $dish = $this->Dishes->find()
                ->where(['Dishes.id' => $id])
                ->contain(['Restaurants'])
                ->first();
        }

        if ($this->request->is(['POST', 'PUT', 'PATCH']) && !empty($this->request->getData())) {
            $dish = $this->Dishes->patchEntity($dish, $this->request->getData());

            if ($this->Dishes->save($dish)) {
                $this->Flash->success(__("Plat sauvegardé avec succès ! Demande de validation soumise."));
                return $this->redirect(['_name' => 'resto:edit', 'id' => $resto]);
            } else {
                $this->Flash->error(__("Des champs ne sont pas valides, veuillez corriger les erreurs"));
            }
        }

        $resto = $this->Dishes->Restaurants->get($resto);
        $dish_types = $this->Dishes->DishTypes->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])
            ->matching('Restaurants', function (Query $query) use ($resto) {
                return $query->where(['restaurant_id' => $resto->id]);
            })
            ->all()
            ->toArray();

        $this->set(compact('dish', 'resto', 'dish_types'));
    }

    /**
     * Suppression du plat du restaurant
     * @param $resto - Identifiant du restaurant
     * @param $dish - Identifiant du plat
     * @return \Cake\Http\Response|null
     */
    public function delete ($resto, $dish) {
        $this->request->allowMethod(['POST', 'DELETE']);

        $dish = $this->Dishes->find()
            ->where([
                'Dishes.id' => $dish
            ])
            ->matching('Restaurants', function (Query $query) use ($resto) {
                return $query->where([
                    'restaurant_id' => $resto,
                    'user_id' => $this->Auth->user('id')
                ]);
            })
            ->firstOrFail();

        if ($this->Dishes->delete($dish)) {
            $this->Flash->success(__("Plat supprimé avec succès !"));
        } else {
            $this->Flash->error(__("Une erreur s'est produite lors de la suppression du plat."));
        }

        return $this->redirect(['_name' => 'resto:edit', 'id' => $resto]);
    }
}
