<?php

namespace WriteDown\API;

use Doctrine\ORM\EntityManager;
use WriteDown\API\Post\Post;

class API
{
    /**
     * The EntityManager object.
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $db;

    /**
     * Set-up.
     *
     * @param Doctrine\ORM\EntityManager $database
     *
     * @return void
     */
    public function __construct(EntityManager $database)
    {
        $this->db = $database;
    }

    /**
     * Work with posts.
     *
     * @return WriteDown\API\Post\Post;
     */
    public function post()
    {
        return new Post($this->db);
    }
}
