<?php

namespace ByRobots\WriteDown\Database\Entities;

/**
 * @Entity(repositoryClass="ByRobots\WriteDown\Database\Repositories\Post")
 * @Table(name="posts")
 * @HasLifecycleCallbacks
 */
class Post extends Base
{
    use EntityTimestamps;

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /** @Column(type="string") */
    public $title;

    /** @Column(type="text", unique=true) */
    public $slug;

    /** @Column(type="text", nullable=true) */
    public $excerpt;

    /** @Column(type="text") */
    public $body;

    /** @Column(name="publish_at", type="datetime", nullable=true) */
    public $publish_at;

    /**
     * Contains the validation rules for creation of the entity.
     *
     * @var array
     */
    protected $rules = [
        'title' => ['present', 'not_empty'],
        'body'  => ['present', 'not_empty'],
        'slug'  => ['present', 'not_empty', 'valid_slug', 'unique_in_database' => [
            'repository' => 'ByRobots\WriteDown\Database\Entities\Post',
        ]],
    ];

    /**
     * Columns that can be set by a user.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'excerpt', 'body', 'publish_at'];
}
