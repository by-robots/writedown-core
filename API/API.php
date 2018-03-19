<?php

namespace WriteDown\API;

use Doctrine\ORM\EntityManager;
use WriteDown\API\Post\Post;
use WriteDown\Validator\Validator;

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
     * Validates data.
     *
     * @var \WriteDown\Validator\Validator
     */
    private $validator;

    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager    $database
     * @param \WriteDown\API\ResponseBuilder $response
     * @param \WriteDown\Validator\Validator $validator
     *
     * @return void
     */
    public function __construct(EntityManager $database, ResponseBuilder $response, Validator $validator)
    {
        $this->db        = $database;
        $this->response  = $response;
        $this->validator = $validator;
    }

    /**
     * Work with posts.
     *
     * @return \WriteDown\API\Post\Post;
     */
    public function post()
    {
        return new Post($this->db, $this->response, $this->validator);
    }
}
