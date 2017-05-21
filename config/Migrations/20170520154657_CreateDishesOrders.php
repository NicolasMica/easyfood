<?php
use Migrations\AbstractMigration;

class CreateDishesOrders extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('dishes_orders');

        $table->addColumn('dish_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ])->addForeignKey('dish_id', 'dishes', 'id', [
            'delete'=> 'SET_NULL',
            'update'=> 'CASCADE'
        ]);

        $table->addColumn('order_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ])->addForeignKey('order_id', 'orders', 'id', [
            'delete'=> 'CASCADE',
            'update'=> 'CASCADE'
        ]);

        $table->addColumn('amount', 'integer', [
            'default' => 1,
            'limit' => 11,
            'null' => false,
        ]);

        $table->create();
    }
}
