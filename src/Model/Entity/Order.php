<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;

/**
 * Order Entity
 *
 * @property int $id
 * @property string $payment
 * @property \Cake\I18n\Time $date
 * @property int $user_id
 * @property \Cake\I18n\Time $created
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Dish[] $dishes
 */
class Order extends Entity
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

    public function _getTotal () {
        $total = 0;

        if (!$this->has('dishes')) {
            TableRegistry::get('Orders')->loadInto($this, [
                'Dishes' => function (Query $query) {
                    return $query->select(['selling_price']);
                }
            ]);
        }

        foreach ($this->dishes as $dish) {
            $total += $dish->selling_price * $dish->_joinData->amount;
        }

        return $total;
    }
}
