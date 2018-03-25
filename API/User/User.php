<?php

namespace WriteDown\API\User;

use Doctrine\ORM\EntityManager;
use WriteDown\API\CRUD;
use WriteDown\API\EndpointInterface;
use WriteDown\API\ResponseBuilder;
use WriteDown\Emails\EmailInterface;
use WriteDown\Validator\ValidatorInterface;

class User extends CRUD implements EndpointInterface
{
    /**
     * Validates emails are unique.
     *
     * @var \WriteDown\Emails\EmailInterface
     */
    private $emails;

    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager             $db
     * @param \WriteDown\API\ResponseBuilder          $response
     * @param \WriteDown\Validator\ValidatorInterface $validator
     * @param \WriteDown\Emails\EmailInterface        $emails
     *
     * @return void
     */
    public function __construct(EntityManager $db, ResponseBuilder $response, ValidatorInterface $validator, EmailInterface $emails)
    {
        $this->db         = $db;
        $this->response   = $response;
        $this->validator  = $validator;
        $this->emails     = $emails;

        // Set additional CRUD settings
        $this->entityRepo = 'WriteDown\Entities\User';
        $this->entity     = 'User';
    }

    /**
     * Create a new entity.
     *
     * @param array $attributes
     *
     * @return array
     */
    public function create(array $attributes)
    {
        if (
            array_key_exists('email', $attributes) and
            !$this->emails->isUnique($attributes['email'])
        ) {
            return $this->response->build([
                'email' => 'The email value is not unique.'
            ], false);
        }

        return parent::create($attributes);
    }

    /**
     * Update an entity.
     *
     * @param int   $entityID
     * @param array $attributes
     *
     * @return array
     */
    public function update($entityID, array $attributes)
    {
        if (
            array_key_exists('email', $attributes) and
            !$this->emails->isUniqueExcept($attributes['email'], $entityID)
        ) {
            return $this->response->build([
                'email' => 'The email value is not unique.'
            ], false);
        }

        return parent::update($entityID, $attributes);
    }
}
