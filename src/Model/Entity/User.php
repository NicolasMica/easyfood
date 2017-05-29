<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $lastname
 * @property string $firstname
 * @property string $gender
 * @property string $email
 * @property string $password
 * @property bool $newsletter
 * @property string $address
 * @property int $city_id
 * @property int $role_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\Token[] $tokens
 */
class User extends Entity
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
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    /**
     * Surcharge du setter du champ password pour implémenter le hash
     * @param $password - Valeur du champ
     * @return bool|string - Valeur hashé du champ
     */
    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }

    /**
     * Attribut virtuel correspondant au nom complet de l'utilisateur
     * @return string - Nom complet
     */
    public function _getFullname () {
        return $this->_properties['firstname'] . ' ' . $this->_properties['lastname'];
    }
}
