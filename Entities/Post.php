<?php

namespace WriteDown\Models;

/**
 * @Entity
 * @Table(name="posts")
 */
class Post
{
    /** @Column(type="integer") */
    private $id;

    /** @Column(type="string") */
    private $title;

    /** @Column(type="text", unique="true") */
    private $slug;

    /** @Column(type="text", nullable="true") */
    private $excerpt;

    /** @Column(type="text") */
    private $body;

    /** @Column(type="datetime", nullable="true") */
    private $publishAt;

    /** @Column(type="datetime", name="created_at") */
    private $createdAt;

    /** @Column(type="datetime", name="updated_at") */
    private $updatedAt;
}
