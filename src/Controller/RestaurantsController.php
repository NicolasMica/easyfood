<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Query;

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
}
