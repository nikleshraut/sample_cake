<?php
use Migrations\AbstractMigration;

class Users extends AbstractMigration
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
        $table = $this->table('users');
        $table->addColumn('email', 'string', ['default'=>null, 'limit'=>128, 'null'=>false]);
        $table->addColumn('password', 'string', ['default'=>null, 'limit'=>128, 'null'=>false]);
        $table->addColumn('user_image', 'string', ['default'=>"", 'limit'=>128, 'null'=>true]);
        $table->addColumn('created', 'datetime', ['default'=>null, 'null'=>false]);
        $table->addColumn('modified', 'datetime', ['default'=>null, 'null'=>false]);
        $table->create();
    }
}
