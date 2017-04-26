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

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
//        $this->paginate = [
//            'contain' => ['Departments']
//        ];
        $cities = $this->Cities->find()
            ->distinct('Cities.id')
            ->matching('Restaurants.Dishes', function (Query $q) {
                return $q->where(['Dishes.active' => true]);
            })
            ->all();

        $this->set(compact('cities'));
        $this->set('_serialize', ['cities']);
    }
}