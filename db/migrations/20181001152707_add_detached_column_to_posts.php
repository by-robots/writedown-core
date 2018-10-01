<?php

use Phinx\Migration\AbstractMigration;

class AddDetachedColumnToPosts extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('posts');
        $table->addColumn('detached', 'boolean', [
            'default' => false,
        ])->update();
    }
}
