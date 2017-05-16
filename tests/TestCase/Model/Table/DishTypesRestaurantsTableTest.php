<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DishTypesRestaurantsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DishTypesRestaurantsTable Test Case
 */
class DishTypesRestaurantsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DishTypesRestaurantsTable
     */
    public $DishTypesRestaurants;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dish_types_restaurants',
        'app.restaurants',
        'app.cities',
        'app.users',
        'app.roles',
        'app.tokens',
        'app.dishes',
        'app.dish_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DishTypesRestaurants') ? [] : ['className' => 'App\Model\Table\DishTypesRestaurantsTable'];
        $this->DishTypesRestaurants = TableRegistry::get('DishTypesRestaurants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DishTypesRestaurants);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
