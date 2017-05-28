<?php
namespace App\View\Cell;

use Cake\ORM\TableRegistry;
use Cake\View\Cell;

/**
 * Admin cell
 */
class AdminCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Warkaround to avoid requesting twice
     * @var array
     */
    protected static $_data = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
        if (!isset(self::$_data['dishes_count'])) {
            self::$_data['dishes_count'] = TableRegistry::get('Dishes')->find('queue')
                ->cache('pendding_dishes_count')
                ->count();
        }

        if (!isset(self::$_data['reviews_count'])) {
            self::$_data['reviews_count'] = TableRegistry::get('Reviews')->find('queue')
                ->cache('pendding_reviews_count')
                ->count();
        }

        $this->set([
            'dishesCount' => self::$_data['dishes_count'],
            'reviewsCount' => self::$_data['reviews_count']
        ]);
    }
}
