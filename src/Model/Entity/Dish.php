<?php
namespace App\Model\Entity;

use Cake\Filesystem\Folder;
use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * Dish Entity
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $supplier_price
 * @property string $selling_price
 * @property bool $active
 * @property int $restaurant_id
 * @property int $dish_type_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Restaurant $restaurant
 * @property \App\Model\Entity\DishType $dish_type
 */
class Dish extends Entity
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

    protected $_virtual = ['picture'];

    public function _getPicture () {
        if (isset($this->_properties['id'])) {
            $dir = new Folder(WWW_ROOT . DS . 'storage' . DS . 'dishes' . DS);
            $files = $dir->find($this->_properties['id'] . '\.(jpg|png|jpeg)');

            if ($files) return Router::url('/storage/dishes/' . $files[0], true);
        }

        return Router::url('/img/logo.png', true);
    }
}
