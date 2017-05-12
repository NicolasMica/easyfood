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

        debug($this->request->getData());

        $cities = TableRegistry::get('Cities')->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])->toArray();

        if ($id !== null) {
            $resto = $this->Restaurants->find()
                ->contain(['Dishes'])
                ->where(['id' => $id])
                ->first();

            $dish_types = TableRegistry::get('DishTypes')->find('list')
                ->select('name')
                ->matching('Restaurants', function (Query $query) use ($resto) {
                    return $query->where(['Restaurants.id' => $resto->id]);
                })
                ->all()
                ->toArray();

//            if ($resto === null) throw new NotFoundException;
        } else {
            $resto = $this->Restaurants->newEntity();
        }

        /*if ($this->request->is(['POST', 'PUT', 'PATCH']) && !empty($this->request->getData())) {
            $resto = $this->Restaurants->patchEntities($resto, $this->request->getData(), ['associated' => ['DishTypes']]);

            if ($this->Restaurants->save($resto)) {
                $this->Flash->success(__("Restaurant sauvegardé avec succès !"));
            } else {
                $this->Flash->error(__("Des champs ne sont pas valides, veuillez corriger les erreurs"));
            }
        }*/

        $this->set(compact('resto', 'cities', 'dish_types'));
    }
}
