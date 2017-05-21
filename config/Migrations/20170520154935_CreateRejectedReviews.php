<?php
use Migrations\AbstractMigration;

class CreateRejectedReviews extends AbstractMigration
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
        $table = $this->table('rejected_reviews');

        $table->addColumn('content', 'text', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('review_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ])->addForeignKey('review_id', 'reviews', 'id', [
            'delete'=> 'CASCADE',
            'update'=> 'CASCADE'
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->create();
    }
}
