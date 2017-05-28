<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Cache\Cache;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

/**
 * Restaurants Controller
 *
 * @property \App\Model\Table\RestaurantsTable $Restaurants
 */
class RestaurantsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['index']);
    }

    /**
     * Liste des restaurants ayant au moins un plat
     * Le résultat de la requête est mis en cache
     * @return \Cake\Network\Response|null
     */
    public function index () {
        $restaurants = $this->Restaurants->find()
            ->select(['id', 'name'])
            ->distinct('Restaurants.id')
            ->matching('Dishes', function (Query $q) {
                return $q->where(['Dishes.active' => true]);
            })
            ->cache('restaurants')
            ->all();

        $this->set(compact('restaurants'));
        $this->set('_serialize', ['restaurants']);
    }

    /**
     * Liste des restaurants de l'utilisateur
     */
    public function view () {
        $restaurants = $this->Restaurants->find()
            ->where(['user_id' => $this->Auth->user('id')])
            ->cache('my_restaurants')
            ->all();

        $this->set(compact('restaurants'));
    }

    /**
     * Création ou modification d'un restaurant de l'utilisateur
     * @param null $id - Identifiant du restaurant
     * @return \Cake\Http\Response|null
     */
    public function save ($id = null) {

        $types = [];

        if ($id === null) {
            $resto = $this->Restaurants->newEntity();
            $resto->user_id = $this->Auth->user('id');
        } else {
            $resto = $this->Restaurants->find()
                ->contain([
                    'Dishes' => function (Query $query) {
                        return $query->select(['id', 'name', 'selling_price', 'restaurant_id', 'active']);
                    },
                    'Dishes.DishTypes' => function (Query $query) {
                        return $query->select(['id', 'name']);
                    }
                ])
                ->where([
                    'id' => $id,
                    'user_id' => $this->Auth->user('id')
                ])
                ->firstOrFail();

            if (!$this->request->getData('dish_types')) {
                $types = TableRegistry::get('DishTypes')->find('list')
                    ->select(['id', 'name'])
                    ->matching('Restaurants', function (Query $query) use ($resto) {
                        return $query->where(['Restaurants.id' => $resto->id]);
                    })
                    ->orderAsc('DishTypes.name')
                    ->toArray();
            }
        }

        $cities = TableRegistry::get('Cities')->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->toArray();

        $dish_types = TableRegistry::get('DishTypes')->find('list')
            ->select('name')
            ->orderAsc('name')
            ->toArray();

        if ($this->request->is(['POST', 'PUT', 'PATCH']) && !empty($this->request->getData())) {

            $types = explode(',', $this->request->getData('dish_types'));
            $selectedTypes = [];
            foreach ($types as $type) {
                if ($type == '') continue;
                $selectedTypes[] = $this->Restaurants->DishTypes->findOrCreate(['name' => ucfirst($type)]);
            }

            $resto = $this->Restaurants->patchEntity($resto, $this->request->getData());
            $resto->dish_types = $selectedTypes;

            if ($this->Restaurants->save($resto)) {
                $this->Flash->success(__("Restaurant sauvegardé avec succès !"));
                return $this->redirect(['_name' => 'resto:view']);
            } else {
                $this->Flash->error(__("Des champs ne sont pas valides, veuillez corriger les erreurs"));
            }
        }

        $this->set(compact('resto', 'cities', 'dish_types', 'types'));
    }

    /**
     * Supression du restaurant
     * @param $id - Identifiant du restaurant
     * @return \Cake\Http\Response|null
     */
    public function delete ($id) {
        $this->request->allowMethod(['POST', 'DELETE']);

        $resto = $this->Restaurants->find()
            ->where([
                'id' => $id,
                'user_id' => $this->Auth->user('id')
            ])
            ->firstOrFail();

        if ($this->Restaurants->delete($resto)) {
            $this->Flash->success(__("Restaurant supprimé avec succès !"));
        } else {
            $this->Flash->error(__("Une erreur s'est produite lors de la suppression du restaurant."));
        }

        return $this->redirect(['_name' => 'resto:view']);
    }
}
