<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 */
class OrdersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        $this->Security->setConfig('unlockedActions', ['add']);
    }

    // TODO: list + cache
    public function index () {
        $orders = $this->Orders->find()
            ->where(['user_id' => $this->Auth->user('id')])
            ->cache($this->Auth->user('id') . '-orders');

        $this->set(compact('orders'));
    }

    public function view ($id) {
        $order = $this->Orders->find()
            ->where([
                'Orders.id' => $id,
                'user_id' => $this->Auth->user('id')
            ])
            ->contain([
                'Dishes' => function (Query $query) {
                    return $query->select(['id', 'name', 'selling_price', 'restaurant_id']);
                },
                'Dishes.DishTypes' => function (Query $query) {
                    return $query->select(['name']);
                },
                'Dishes.Restaurants' => function (Query $query) {
                    return $query->select(['name']);
                }
            ])
            ->firstOrFail();

        $this->set(compact('order'));
    }

    /**
     * Enregistre une commande
     * @return \Cake\Http\Response
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $order = $this->Orders->newEntity();

            // TODO: fix order problem
            $data = $this->request->getData();
            $data['date'] = new Time($data['date']);
            $data['user_id'] = $this->Auth->user('id');
            $data['total'] = 0;

            foreach ($data['dishes'] as $key => $dish) {
                $data['dishes'][$key]['_joinData']['amount'] = $dish['amount'];
                $data['total'] += $dish['selling_price'];
            }

            $order = $this->Orders->patchEntity($order, $data);

            if ($this->Orders->save($order)) {
                $message = __('<i class="material-icons left green-text">check</i> Commande enregistrée avec succès !');
                $code = 200;
                $success = true;
                Cache::deleteMany([$this->Auth->user('id') . '-last-orders', $this->Auth->user('id') . '-orders']);
            } else {
                $message = __("<i class='material-icons left red-text'>close</i> Une erreur s'est produite lors de l'enregistrement de votre commande.");
                $code = 422;
                $success = false;
            }

            return $this->response->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => $success,
                    'message' => $message
                ]))->withStatus($code);
        }
    }
}
