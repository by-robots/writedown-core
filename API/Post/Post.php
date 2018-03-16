<?php

namespace WriteDown\API\Post;

use Doctrine\ORM\EntityManager;

class Post
{
    /**
     * The EntityManager.
     *
     * @var Doctrine\ORM\EntityManager
     */
    private $db;

    /**
     * Set-up.
     *
     * @return void
     */
    public function __construct(EntityManager $db)
    {
        $this->db = $db;
    }

    /**
     * List all posts.
     *
     * @return array
     */
    public function index()
    {
        $posts = $this->db->getRepository('WriteDown\Entities\Post')->findAll();
        return $posts;
    }
}
