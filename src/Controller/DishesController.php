<?php
namespace App\Controller;

use App\Controller\AppController;
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
        $dishes = $this->Dishes->find('published')
            ->contain([
                'Restaurants' => function (Query $q) {
                    return $q->select(['Restaurants.id', 'Restaurants.name', 'Restaurants.city_id']);
                },
                'DishTypes' => function (Query $q) {
                    return $q->enableAutoFields();
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
            ->distinct('DishTypes.id')
            ->matching('Dishes', function (Query $q) {
                return $q->where(['Dishes.active' => true]);
            })
            ->cache('dish_types')
            ->all();

        $this->set(compact('dishTypes'));
        $this->set('_serialize', ['dishTypes']);
    }
}
