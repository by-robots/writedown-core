<?php

namespace WriteDown\Entities;

/**
 * @Entity
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

    /** @Column(name="created_at", type="datetime") */
    protected $created_at;

    /** @Column(name="updated_at", type="datetime") */
    protected $updated_at;
}
