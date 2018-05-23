<?php

namespace ByRobots\WriteDown\API\Endpoints;

use ByRobots\WriteDown\API\CRUD;
use ByRobots\WriteDown\API\Interfaces\EndpointInterface;
use ByRobots\WriteDown\API\ResponseBuilder;
use ByRobots\WriteDown\API\Transformers\PostTagTransformer;
use ByRobots\WriteDown\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManager;

class PostTag extends CRUD implements EndpointInterface
{

    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager                      $db
     * @param \ByRobots\WriteDown\API\ResponseBuilder          $response
     * @param \ByRobots\WriteDown\Validator\ValidatorInterface $validator
     *
     * @return void
     */
    public function __construct(
        EntityManager $db,
        ResponseBuilder $response,
        ValidatorInterface $validator
    ) {
        $this->db          = $db;
        $this->response    = $response;
        $this->validator   = $validator;

        // Set additional CRUD settings
        $this->entityRepo = 'ByRobots\WriteDown\Database\Entities\PostTag';
        $this->entity     = 'PostTag';

        // Set the transformer for this model
        $this->response->setTransformer(new PostTagTransformer); // TODO: Inject this
    }
}
