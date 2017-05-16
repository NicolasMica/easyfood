<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DishTypesRestaurantsFixture
 *
 */
class DishTypesRestaurantsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'restaurant_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'dish_type_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'restaurant_id' => ['type' => 'index', 'columns' => ['restaurant_id'], 'length' => []],
            'dish_type_id' => ['type' => 'index', 'columns' => ['dish_type_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'dish_types_restaurants_ibfk_1' => ['type' => 'foreign', 'columns' => ['restaurant_id'], 'references' => ['restaurants', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'dish_types_restaurants_ibfk_2' => ['type' => 'foreign', 'columns' => ['dish_type_id'], 'references' => ['dish_types', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'restaurant_id' => 1,
            'dish_type_id' => 1
        ],
    ];
}
