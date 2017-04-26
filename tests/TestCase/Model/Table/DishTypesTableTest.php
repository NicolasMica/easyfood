<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DishTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DishTypesTable Test Case
 */
class DishTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DishTypesTable
     */
    public $DishTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dish_types',
        'app.dishes',
        'app.restaurants',
        'app.cities',
        'app.departments',
        'app.users',
        'app.roles',
        'app.tokens',
        'app.dish_types_restaurants'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DishTypes') ? [] : ['className' => 'App\Model\Table\DishTypesTable'];
        $this->DishTypes = TableRegistry::get('DishTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DishTypes);

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
}
