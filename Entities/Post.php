<?php

namespace WriteDown\Entities;

use WriteDown\Misc\Slugger;

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
     * Contains the validation rules for the entity.
     *
     * @var array
     */
    protected $rules = [
        'title' => ['required'],
        'body'  => ['required'],
    ];

    /**
     * Columns that can be set by a user.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'excerpt', 'body', 'publish_at'];

    /**
     * Before the post is persisted set the slug assuming it's not been manually
     * specified.
     *
     * @PrePersist
     */
    public function generateSlug()
    {
        if (empty($this->slug)) {
            $slugger    = new Slugger;
            $this->slug = $slugger->slug($this->title);
        }
    }
}
