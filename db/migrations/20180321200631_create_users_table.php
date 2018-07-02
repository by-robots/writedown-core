<?php


use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('email', 'string')
              ->addColumn('password', 'string')
              ->addColumn('token', 'string')
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime')
              ->addIndex(['email'], ['unique' => true])
              ->create();
    }
}
