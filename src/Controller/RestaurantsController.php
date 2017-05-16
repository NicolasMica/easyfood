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
            ->distinct('Restaurants.id')
            ->matching('Dishes', function (Query $q) {
                return $q->where(['Dishes.active' => true]);
            })
            ->cache('restaurants')
            ->all();

        $this->set(compact('restaurants'));
        $this->set('_serialize', ['restaurants']);
    }

    public function view () {
        Cache::delete('my_restaurants');
        $restaurants = $this->Restaurants->find()
            ->where(['user_id' => $this->Auth->user('id')])
            ->cache('my_restaurants')
            ->all();

        $this->set(compact('restaurants'));
    }

    public function save ($id = null) {

        $types = [];

        $cities = TableRegistry::get('Cities')->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->toArray();

        $dish_types = TableRegistry::get('DishTypes')->find('list')
            ->select('name')
            ->all()
            ->toArray();

        if ($id === null) {
            $resto = $this->Restaurants->newEntity();
            $resto->user_id = $this->Auth->user('id');
        } else {
            $resto = $this->Restaurants->find()
                ->contain([
                    'Dishes' => function (Query $query) {
                        return $query->select(['id', 'name', 'selling_price', 'restaurant_id']);
                    },
                    'Dishes.DishTypes' => function (Query $query) {
                        return $query->select(['id', 'name']);
                    }
                ])
                ->where(['id' => $id])
                ->first();

            if (!$this->request->getData('dish_types')) {
                $types = TableRegistry::get('DishTypes')->find('list')
                    ->select(['id', 'name'])
                    ->matching('Restaurants', function (Query $query) use ($resto) {
                        return $query->where(['Restaurants.id' => $resto->id]);
                    })
                    ->all()
                    ->toArray();
            }

            if ($resto === null) throw new NotFoundException;
        }

        if ($this->request->is(['POST', 'PUT', 'PATCH']) && !empty($this->request->getData())) {

            $types = explode(',', $this->request->getData('dish_types'));
            $selectedTypes = [];
            foreach ($types as $type) {
                $selectedTypes[] = $this->Restaurants->DishTypes->findOrCreate(['name' => $type]);
            }

            $resto = $this->Restaurants->patchEntity($resto, $this->request->getData());
            $resto->dish_types = $selectedTypes;

            if ($this->Restaurants->save($resto)) {
                $this->Flash->success(__("Restaurant sauvegardé avec succès !"));
                if ($id === null) return $this->redirect(['_name' => 'resto:edit', 'id' => $resto->id]);
            } else {
                $this->Flash->error(__("Des champs ne sont pas valides, veuillez corriger les erreurs"));
            }
        }

        $this->set(compact('resto', 'cities', 'dish_types', 'types'));
    }
}
