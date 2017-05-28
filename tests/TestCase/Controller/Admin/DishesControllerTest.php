<?php
namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\DishesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\Admin\DishesController Test Case
 */
class DishesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
