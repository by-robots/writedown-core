<?php

namespace ByRobots\WriteDown\API\Endpoints;

use ByRobots\WriteDown\API\ResponseBuilder;
use ByRobots\WriteDown\API\Transformers\TagTransformer;
use ByRobots\WriteDown\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManager;
use ByRobots\WriteDown\API\CRUD;
use ByRobots\WriteDown\API\Interfaces\CRUInterface;

class Tag extends CRUD implements CRUInterface
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
    public function __construct(EntityManager $db, ResponseBuilder $response, ValidatorInterface $validator)
    {
        $this->db        = $db;
        $this->response  = $response;
        $this->validator = $validator;

        // Set additional CRUD settings
        $this->entityRepo = 'ByRobots\WriteDown\Database\Entities\Tag';
        $this->entity     = 'Tag';

        // Set the transformer for this model
        $this->response->setTransformer(new TagTransformer); // TODO: Inject this
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes) : array
    {
        return parent::create($attributes);
    }
}
