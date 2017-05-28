<?php
use Migrations\AbstractMigration;

class CreateReviews extends AbstractMigration
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
        $table = $this->table('reviews');

        $table->addColumn('quality', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);

        $table->addColumn('recipe', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);

        $table->addColumn('design', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);

        $table->addColumn('price', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);

        $table->addColumn('delivery', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);

        $table->addColumn('employee', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);

        $table->addColumn('content', 'text', [
            'default' => null,
            'null' => false
        ]);

        $table->addColumn('active', 'boolean', [
            'default' => 0,
            'null' => false,
        ]);

        $table->addColumn('restaurant_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ])->addForeignKey('restaurant_id', 'restaurants', 'id', [
            'delete'=> 'CASCADE',
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

        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->create();
    }
}
