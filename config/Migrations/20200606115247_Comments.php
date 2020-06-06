<?php
use Migrations\AbstractMigration;

class Comments extends AbstractMigration
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
        $table = $this->table('comments');
        $table->addColumn('comment', 'string', ['default'=>null, 'limit'=>255, 'null'=>false ]);
        $table->addColumn('article_id','integer', ['default'=>null, 'null'=>false]);
        $table->addColumn('user_id','integer', ['default'=>null, 'null'=>false]);
        $table->addColumn('created', 'datetime', ['default'=>null, 'null'=>false ]);
        $table->addColumn('modified', 'datetime', ['default'=>null, 'null'=>false ]);
        $table->addForeignKey('article_id','articles','id');
        $table->addForeignKey('user_id','users','id');
        $table->create();
    }
}
