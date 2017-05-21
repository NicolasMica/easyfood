<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DishesOrdersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DishesOrdersTable Test Case
 */
class DishesOrdersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DishesOrdersTable
     */
    public $DishesOrders;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dishes_orders',
        'app.dishes',
        'app.restaurants',
        'app.cities',
        'app.users',
        'app.roles',
        'app.tokens',
        'app.dish_types',
        'app.dish_types_restaurants',
        'app.orders'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DishesOrders') ? [] : ['className' => 'App\Model\Table\DishesOrdersTable'];
        $this->DishesOrders = TableRegistry::get('DishesOrders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DishesOrders);

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
