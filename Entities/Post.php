<?php

namespace WriteDown\Entities;

/**
 * @Entity(repositoryClass="WriteDown\Repositories\Post")
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
    protected $title;

    /** @Column(type="text", unique=true) */
    protected $slug;

    /** @Column(type="text", nullable=true) */
    protected $excerpt;

    /** @Column(type="text") */
    protected $body;

    /** @Column(name="publish_at", type="datetime", nullable=true) */
    protected $publish_at;

    /**
     * Set the validation fillable columns and validation rules for this entity.
     *
     * @return void
     */
    public function __construct()
    {
        $this->fillable = ['title', 'slug', 'excerpt', 'body', 'publish_at'];
        $this->rules    = [
            'title' => ['required'],
            'body'  => ['required'],
        ];
    }
}
