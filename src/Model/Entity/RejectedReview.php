<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RejectedReview Entity
 *
 * @property int $id
 * @property string $content
 * @property int $review_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Review $review
 */
class RejectedReview extends Entity
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
