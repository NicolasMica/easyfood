<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Query;

/**
 * Cities Controller
 *
 * @property \App\Model\Table\CitiesTable $Cities
 */
class CitiesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['index']);
    }

    /**
     * Liste des villes ayant un restaurant avec au minimum un plat
     * Le résultat de la requête est mis en cache
     * @return \Cake\Network\Response|null
     */
    public function index () {
        $cities = $this->Cities->find()
            ->select(['id', 'name'])
            ->distinct('Cities.id')
            ->matching('Restaurants.Dishes', function (Query $q) {
                return $q->where(['Dishes.active' => true]);
            })
            ->cache('cities')
            ->all();

        $this->set(compact('cities'));
        $this->set('_serialize', ['cities']);
    }
}
