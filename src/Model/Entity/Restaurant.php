<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * Restaurant Entity
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $address
 * @property int $city_id
 * @property int $user_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Dish[] $dishes
 * @property \App\Model\Entity\DishType[] $dish_types
 */
class Restaurant extends Entity
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

    protected $_virtual = ['slug', 'link'];

    public function _getSlug () {
        return Text::slug(strtolower($this->_properties['name']));
    }

    public function _getLink () {
        return Router::url(['_name' => 'resto:view', 'slug' => $this->_getSlug(), 'id' => $this->_properties['id']]);
    }
}
