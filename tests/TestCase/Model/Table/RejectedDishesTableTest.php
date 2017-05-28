<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RejectedDishesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RejectedDishesTable Test Case
 */
class RejectedDishesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RejectedDishesTable
     */
    public $RejectedDishes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.rejected_dishes',
        'app.dishes',
        'app.restaurants',
        'app.cities',
        'app.users',
        'app.roles',
        'app.tokens',
        'app.dish_types',
        'app.dish_types_restaurants',
        'app.orders',
        'app.dishes_orders',
        'app.reviews',
        'app.rejected_reviews'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RejectedDishes') ? [] : ['className' => 'App\Model\Table\RejectedDishesTable'];
        $this->RejectedDishes = TableRegistry::get('RejectedDishes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RejectedDishes);

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
