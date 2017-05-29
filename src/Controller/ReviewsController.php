<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

/**
 * Reviews Controller
 *
 * @property \App\Model\Table\ReviewsTable $Reviews
 *
 * @method \App\Model\Entity\Review[] paginate($object = null, array $settings = [])
 */
class ReviewsController extends AppController
{

    /**
     * Sauvegarde un avis concercnant une commande
     * @param $orderId - Identifiant de la commande
     * @return \Cake\Http\Response|null
     */
    public function save ($orderId) {

        $review = $this->Reviews->find()
            ->where([
                'order_id' => $orderId,
                'active' => false
            ])
            ->innerJoinWith('Orders', function (Query $query) {
                return $query->where(['user_id' => $this->Auth->user('id')]);
            })
            ->contain([
                'Orders',
                'Orders.Dishes',
                'Orders.Dishes.DishTypes',
                'Orders.Dishes.Restaurants'
            ])
            ->first();

        if (!$review) {
            $review = $this->Reviews->newEntity();
            $review->order = TableRegistry::get('Orders')->find()
                ->contain([
                    'Dishes',
                    'Dishes.DishTypes',
                    'Dishes.Restaurants'
                ])
                ->where([
                    'id' => $orderId,
                    'user_id' => $this->Auth->user('id')
                ])->firstOrFail();
            $review->restaurant = $review->order->dishes[0]->restaurant;
        }

        if ($this->request->is(['POST', 'PUT', 'PATCH']) && $this->request->getData()) {
            $review = $this->Reviews->patchEntity($review, $this->request->getData());
            if ($this->Reviews->save($review)) {
                $this->Flash->success(__("Avis sauvegardé avec succès ! Demande de validation soumise."));
                return $this->redirect(['_name' => 'orders:index']);
            } else {
                $this->Flash->error(__("Veuillez corriger les erreurs."));
            }
        }


        $this->set(compact('review'));
    }

    /**
     * Affiche un résumé de la commande et son évaluation
     * @param $orderId - Identifiant de la commande associée à l'évaluation
     */
    public function view ($orderId) {
        $review = $this->Reviews->find()
            ->where([
                'order_id' => $orderId,
                'active' => true
            ])
            ->innerJoinWith('Orders', function (Query $query) {
                return $query->where(['user_id' => $this->Auth->user('id')]);
            })
            ->contain([
                'Orders',
                'Orders.Dishes',
                'Orders.Dishes.DishTypes',
                'Orders.Dishes.Restaurants'
            ])
            ->first();

        $this->set(compact('review'));
    }
}
