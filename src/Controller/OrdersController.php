<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\Routing\Router;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 */
class OrdersController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['add']);
    }

    public function beforeFilter(Event $event)
    {
        $this->Security->setConfig('unlockedActions', ['add']);
    }

    /**
     * Liste les commandes de l'utilisateur
     */
    public function index () {
        $orders = $this->Orders->find()
            ->where(['user_id' => $this->Auth->user('id')])
            ->cache($this->Auth->user('id') . '-orders');

        $this->set(compact('orders'));
    }

    /**
     * Récupère les détails d'une commande
     * @param $id - Identifiant de la commande
     */
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
        if (!$this->Auth->user()) {
            return $this->response->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => "<i class='material-icons left amber-text'>warning</i> Vous devez être connecté afin de pouvoir passer une commande.
                    <a class='btn-flat blue-text waves-effect right' href='" . Router::url(['_name' => 'users:sign'], true) . "' >
                        <i class='material-icons right'>arrow_forward</i> Connexion
                    </a>
                    "
                ]))->withStatus(401);
        }

        if ($this->request->is('post')) {
            $order = [];
            $order['payment'] = $this->request->getData('payment');
            $order['date'] = new Time($this->request->getData('date'));
            $order['date']->timezone = 'Europe/Paris';
            $order['user_id'] = $this->Auth->user('id');
            $order['total'] = 0;
            $order['dishes'] = [];

            foreach ($this->request->getData('dishes') as $dish) {
                $order['total'] += $dish['selling_price'] * $dish['amount'];
                $order['dishes'][] = [
                    'id' => $dish['id'],
                    '_joinData' => [
                        'amount' => $dish['amount']
                    ]
                ];
            }

            $order = $this->Orders->newEntity($order, [
                'associated' => ['Dishes._joinData']
            ]);

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
