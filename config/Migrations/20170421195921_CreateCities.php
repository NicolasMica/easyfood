<?php
use Migrations\AbstractMigration;

class CreateCities extends AbstractMigration
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
        $table = $this->table('cities');

        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);

        $table->addColumn('department_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ])->addForeignKey('department_id', 'departments', 'id', [
            'delete'=> 'SET_NULL',
            'update'=> 'CASCADE'
        ]);

        $table->create();
    }
}
