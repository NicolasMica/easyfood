<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RejectedReviewsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RejectedReviewsTable Test Case
 */
class RejectedReviewsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RejectedReviewsTable
     */
    public $RejectedReviews;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.rejected_reviews',
        'app.reviews',
        'app.restaurants',
        'app.cities',
        'app.users',
        'app.roles',
        'app.tokens',
        'app.dishes',
        'app.dish_types',
        'app.dish_types_restaurants',
        'app.rejected_dishes',
        'app.orders',
        'app.dishes_orders'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('RejectedReviews') ? [] : ['className' => 'App\Model\Table\RejectedReviewsTable'];
        $this->RejectedReviews = TableRegistry::get('RejectedReviews', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RejectedReviews);

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
