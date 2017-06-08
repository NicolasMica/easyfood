<?php
use Migrations\AbstractMigration;

class CreateRestaurants extends AbstractMigration
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
        $table = $this->table('restaurants');

        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);

        $table->addColumn('description', 'text', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('address', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);

        $table->addColumn('city_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ])->addForeignKey('city_id', 'cities', 'id', [
            'delete'=> 'SET_NULL',
            'update'=> 'CASCADE'
        ]);

        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ])->addForeignKey('user_id', 'users', 'id', [
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
