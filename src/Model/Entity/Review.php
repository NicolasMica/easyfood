<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Review Entity
 *
 * @property int $id
 * @property int $quality
 * @property int $recipe
 * @property int $price
 * @property int $delivery
 * @property int $employee
 * @property bool $active
 * @property int $user_id
 * @property int $restaurant_id
 * @property int $order_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Restaurant $restaurant
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\RejectedReview[] $rejected_reviews
 */
class Review extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    /**
     * Attribut virtuel indiquant si l'évaluation est refusée
     * @return bool
     */
    public function _getRejected () {
        if ($this->_properties['active']) return false;

        if ($this->pendding) return false;

        return false;
    }

    /**
     * Attribut virtuel indiquant si l'évaluation est en attente de validation
     * @return bool
     */
    public function _getPendding () {
        if ($this->_properties['active']) return false;

        if (!$this->has('rejected_reviews')) {
            TableRegistry::get('Reviews')->loadInto($this, ['RejectedReviews' => [
                'fields' => ['created', 'review_id']
            ]]);
        }

        foreach ($this->rejected_reviews as $rejected) {
            if ($rejected->created > $this->_properties['modified']) return false;
        }

        return true;
    }
}
