<?php

namespace ByRobots\WriteDown\API;

use ByRobots\WriteDown\API\Endpoints\Post;
use ByRobots\WriteDown\API\Endpoints\PostTag;
use ByRobots\WriteDown\API\Endpoints\Tag;
use ByRobots\WriteDown\API\Endpoints\User;
use ByRobots\WriteDown\API\Interfaces\APIInterface;
use ByRobots\WriteDown\API\Interfaces\CRUInterface;
use ByRobots\WriteDown\API\Interfaces\PostEndpointInterface;
use ByRobots\WriteDown\Slugs\Slugger;
use ByRobots\WriteDown\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManager;

class API implements APIInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $db;

    /**
     * @var \ByRobots\WriteDown\API\ResponseBuilder
     */
    private $response;

    /**
     * @var \ByRobots\WriteDown\Validator\ValidatorInterface
     */
    private $validator;

    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager                      $database
     * @param \ByRobots\WriteDown\API\ResponseBuilder          $response
     * @param \ByRobots\WriteDown\Validator\ValidatorInterface $validator
     *
     * @return void
     */
    public function __construct(
        EntityManager $database,
        ResponseBuilder $response,
        ValidatorInterface $validator
    ) {
        $this->db          = $database;
        $this->response    = $response;
        $this->validator   = $validator;
    }

    /**
     * @inheritDoc
     */
    public function post(Slugger $slugger = null):PostEndpointInterface
    {
        if (!$slugger) {
            $slugger = new Slugger($this->db);
        }

        return new Post($this->db, $this->response, $this->validator, $slugger);
    }

    /**
     * @inheritDoc
     */
    public function user():CRUInterface
    {
        return new User($this->db, $this->response, $this->validator);
    }

    /**
     * @inheritDoc
     */
    public function tag():CRUInterface
    {
        return new Tag($this->db, $this->response, $this->validator);
    }

    /**
     * @inheritDoc
     */
    public function postTag():CRUInterface
    {
        return new PostTag($this->db, $this->response, $this->validator);
    }
}
