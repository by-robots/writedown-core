<?php

namespace ByRobots\WriteDown\API\Endpoints;

use Doctrine\ORM\EntityManager;
use ByRobots\WriteDown\API\CRUD;
use ByRobots\WriteDown\API\Interfaces\CRUInterface;
use ByRobots\WriteDown\API\ResponseBuilder;
use ByRobots\WriteDown\API\Transformers\UserTransformer;
use ByRobots\WriteDown\Validator\ValidatorInterface;

class User extends CRUD implements CRUInterface
{
    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager                      $db
     * @param \ByRobots\WriteDown\API\ResponseBuilder          $response
     * @param \ByRobots\WriteDown\Validator\ValidatorInterface $validator
     * @param \ByRobots\WriteDown\Emails\EmailInterface        $emails
     *
     * @return void
     */
    public function __construct(
        EntityManager $db,
        ResponseBuilder $response,
        ValidatorInterface $validator
    ) {
        $this->db        = $db;
        $this->response  = $response;
        $this->validator = $validator;

        // Set additional CRUD settings
        $this->entityRepo = 'ByRobots\WriteDown\Database\Entities\User';
        $this->entity     = 'User';

        // Set the transformer for this model
        $this->response->setTransformer(new UserTransformer); // TODO: Inject this
    }
}
