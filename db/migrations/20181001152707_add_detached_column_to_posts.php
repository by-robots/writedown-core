<?php


use Phinx\Migration\AbstractMigration;

class AddDetachedColumnToPosts extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('posts');
        $table->add_column('detached', 'boolean', [
            'default' => false,
        ]);
    }
}
