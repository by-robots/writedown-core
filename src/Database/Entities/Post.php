<?php

namespace ByRobots\WriteDown\Database\Entities;

/**
 * @Entity(repositoryClass="ByRobots\WriteDown\Database\Repositories\Post")
 * @Table(name="posts")
 * @HasLifecycleCallbacks
 */
class Post extends Base
{
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
     * Contains the validation rules for the entity.
     *
     * @var array
     */
    protected $rules = [
        'title' => ['present', 'not_empty'],
        'body'  => ['present', 'not_empty'],
        'slug'  => ['present', 'not_empty'],
    ];

    /**
     * Columns that can be set by a user.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'excerpt', 'body', 'publish_at'];
}
