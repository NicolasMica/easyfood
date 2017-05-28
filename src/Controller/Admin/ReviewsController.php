<?php
namespace App\Controller\Admin;
use Cake\Mailer\Email;
use Cake\ORM\Query;
use Cake\Routing\Router;

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
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $reviews = $this->Reviews->find('queue')
            ->contain([
                'Restaurants' => function (Query $query) {
                    return $query->select(['name']);
                }
            ]);

        $this->paginate = ['limit' => 20];

        $this->set(['reviews' => $this->paginate($reviews)]);
        $this->set('_serialize', ['reviews']);
    }

    public function save ($id) {
        $rejected_review = $this->Reviews->RejectedReviews->newEntity();
        $review = $this->Reviews->find()
            ->where(['Reviews.id' => $id])
            ->contain([
                'Orders' => function (Query $query) {
                    return $query->enableAutoFields();
                },
                'Orders.Users' => function (Query $query) {
                    return $query->select(['email', 'firstname', 'lastname']);
                },
                'Orders.Dishes' => function (Query $query) {
                    return $query->enableAutoFields();
                },
                'Orders.Dishes.DishTypes' => function (Query $query) {
                    return $query->enableAutoFields();
                },
                'Orders.Dishes.Restaurants' => function (Query $query) {
                    return $query->select(['id', 'name']);
                },
                'Restaurants' => function (Query $query) {
                    return $query->select(['name']);
                },
            ])
            ->firstOrFail();

        if ($this->request->is(['patch', 'post', 'put'])) {

            $rejected_review->review_id = $review->id;
            $rejected_review = $this->Reviews->RejectedReviews->patchEntity($rejected_review, $this->request->getData());

            if ($this->Reviews->RejectedReviews->save($rejected_review)) {

                $email = new Email();
                $email->setLayout(null)
                    ->setTemplate('validate_reviews')
                    ->setEmailFormat('both')
                    ->setSubject("Refus de validation de l'avis pour la commande n°{$review->order->id}")
                    ->setTo($review->order->user->email, $review->order->user->fullname)
                    ->setViewVars([
                        'fullname' => $review->order->user->fullname,
                        'restaurant_name' => $review->restaurant->name,
                        'order_id' => $review->order->id,
                        'reason' => $rejected_review->content,
                        'link' => Router::url(['_name' => 'reviews:save', 'order' => $review->order->id], true)
                    ])
                    ->send();

                $this->Flash->success(__('Modération sauvegardée avec succès !'));

                return $this->redirect(['_name' => 'admin:reviews:index']);
            } else {
                $this->Flash->error(__('Une erreur s\'est produite lors de la soumission du formulaire'));
            }
        }

        $this->set(compact('review', 'rejected_review'));
        $this->set('_serialize', ['review']);
    }

    public function validate ($id) {
        $this->request->allowMethod(['POST', 'PUT', 'PATCH']);

        if ($review = $this->Reviews->get($id)) {
            $review->active = true;
            if ($this->Reviews->save($review)) {
                $this->Flash->success(__("Avis validé avec succès !"));
            } else {
                $this->Flash->error(__("Une erreur s'est produite lors de la validation de l'avis."));
            }
        }

        return $this->redirect($this->referer());
    }
}
