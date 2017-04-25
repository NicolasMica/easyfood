<?php
use Migrations\AbstractMigration;

class CreateDepartments extends AbstractMigration
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
        $table = $this->table('departments');

        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);

        $table->addColumn('code', 'string', [
            'default' => null,
            'limit' => 3,
            'null' => false,
        ]);

        $table->create();
    }
}
