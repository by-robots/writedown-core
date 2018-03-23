<?php

namespace WriteDown\API\User;

use Doctrine\ORM\EntityManager;
use WriteDown\API\CRUD;
use WriteDown\API\EndpointInterface;
use WriteDown\API\ResponseBuilder;
use WriteDown\Validator\ValidatorInterface;

class User extends CRUD implements EndpointInterface
{
    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager             $db
     * @param \WriteDown\API\ResponseBuilder          $response
     * @param \WriteDown\Validator\ValidatorInterface $validator
     *
     * @return void
     */
    public function __construct(EntityManager $db, ResponseBuilder $response, ValidatorInterface $validator)
    {
        $this->db         = $db;
        $this->response   = $response;
        $this->validator  = $validator;

        // Set additional CRUD settings
        $this->entityRepo = 'WriteDown\Entities\User';
        $this->entity     = 'User';
    }
}
