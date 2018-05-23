<?php

namespace ByRobots\WriteDown\Database\Entities;

/**
 * @Entity(repositoryClass="ByRobots\WriteDown\Database\Repositories\PostTag")
 * @Table(name="post_tag")
 */
class PostTag extends Base
{
    /**
     * @Id
     * @Column(type="integer")
     */
    public $post_id;

    /**
     * @Id
     * @Column(type="integer")
     */
    public $tag_id;

    /**
     * Contains the validation rules for creation of the entity.
     *
     * @var array
     */
    protected $rules = [
        'post_id' => ['present', 'not_empty'],
        'tag_id'  => ['present', 'not_empty'],
    ];

    /**
     * Columns that can be set by a user.
     *
     * @var array
     */
    protected $fillable = ['post_id', 'tag_id'];
}
