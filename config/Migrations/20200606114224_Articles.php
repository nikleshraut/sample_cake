<?php
use Migrations\AbstractMigration;

class Articles extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('articles', ['primary_key'=> ['id'] ]);
        $table->addColumn('user_id', 'integer', ['default'=>null, 'null'=>false]);
        $table->addColumn('title', 'string', ['default'=>null, 'limit'=>255, 'null'=>false]);
        $table->addColumn('slug', 'string', ['default'=>null, 'limit'=>191, 'null'=>false]);
        $table->addColumn('body', 'text', ['default'=>null, 'limit'=>191, 'null'=>false]);
        $table->addColumn('published', 'boolean', ['default'=>false, 'null'=>false]);
        $table->addColumn('created', 'datetime', ['default'=>null, 'null'=>false]);
        $table->addColumn('modified', 'datetime', ['default'=>null, 'null'=>false]);
        $table->create();
    }
}
