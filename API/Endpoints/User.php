<?php

namespace WriteDown\API\Endpoints;

use Doctrine\ORM\EntityManager;
use WriteDown\API\CRUD;
use WriteDown\API\Interfaces\EndpointInterface;
use WriteDown\API\ResponseBuilder;
use WriteDown\API\Transformers\UserTransformer;
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
        $this->entityRepo = 'WriteDown\Database\Entities\User';
        $this->entity     = 'User';

        // Set the transformer for this model
        $this->response->setTransformer(new UserTransformer); // TODO: Inject this
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes) : array
    {
        if (
            array_key_exists('email', $attributes) and
            !$this->emails->isUnique($attributes['email'])
        ) {
            return $this->response->build([
                'email' => ['The email value is not unique.']
            ], false);
        }

        return parent::create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update($entityID, array $attributes) : array
    {
        if (
            array_key_exists('email', $attributes) and
            !$this->emails->isUniqueExcept($attributes['email'], $entityID)
        ) {
            return $this->response->build([
                'email' => ['The email value is not unique.']
            ], false);
        }

        return parent::update($entityID, $attributes);
    }
}
