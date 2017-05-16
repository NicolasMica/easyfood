<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DishTypesRestaurant Entity
 *
 * @property int $id
 * @property int $restaurant_id
 * @property int $dish_type_id
 *
 * @property \App\Model\Entity\Restaurant $restaurant
 * @property \App\Model\Entity\DishType $dish_type
 */
class DishTypesRestaurant extends Entity
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
}
