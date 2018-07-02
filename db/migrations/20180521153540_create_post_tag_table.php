<?php


use Phinx\Migration\AbstractMigration;

class CreatePostTagTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table(
            'post_tag',
            ['id' => false, 'primary_key' => ['post_id', 'tag_id']]
        );

        $table->addColumn('post_id', 'integer')
            ->addColumn('tag_id', 'integer')
            ->addForeignKey('post_id', 'posts', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->addForeignKey('tag_id', 'tags', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->create();
    }
}
