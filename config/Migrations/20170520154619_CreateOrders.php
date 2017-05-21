<?php
use Migrations\AbstractMigration;

class CreateOrders extends AbstractMigration
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
        $table = $this->table('orders');

        $table->addColumn('payment', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);

        $table->addColumn('date', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('total', 'string', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ])->addForeignKey('user_id', 'users', 'id', [
            'delete'=> 'SET_NULL',
            'update'=> 'CASCADE'
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->create();
    }
}
