<?php

namespace WriteDown\API;

use Doctrine\ORM\EntityManager;
use WriteDown\API\Post\Post;

class API
{
    /**
     * The EntityManager object.
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $db;

    /**
     * Builds API responses.
     *
     * @var \WriteDown\API\ResponseBuilder
     */
    private $response;

    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager    $database
     * @param \WriteDown\API\ResponseBuilder $response
     *
     * @return void
     */
    public function __construct(EntityManager $database, ResponseBuilder $response)
    {
        $this->db       = $database;
        $this->response = $response;
    }

    /**
     * Work with posts.
     *
     * @return \WriteDown\API\Post\Post;
     */
    public function post()
    {
        return new Post($this->db, $this->response);
    }
}
