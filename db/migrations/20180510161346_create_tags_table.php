<?php


use Phinx\Migration\AbstractMigration;

class CreateTagsTable extends AbstractMigration
{
    public function change()
    {
	    $table = $this->table('tags');
	    $table->addColumn('name', 'string')
	          ->addColumn('created_at', 'datetime')
	          ->addColumn('updated_at', 'datetime')
	          ->addIndex(['name'], ['unique' => true])
	          ->create();
    }
}
