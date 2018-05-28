<?php

namespace ByRobots\WriteDown\API;

use ByRobots\WriteDown\API\Interfaces\EndpointCRUInterface;

/**
 * Implement the Create, Read and Update methods for endpoints.
 */
class CRU implements EndpointCRUInterface
{
    /**
     * The entity repo.
     *
     * @var string
     */
    protected $entityRepo;

    /**
     * The fully qualified entity class name.
     *
     * @var string
     */
    protected $entity;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $db;

    /**
     * @var \ByRobots\WriteDown\API\ResponseBuilder
     */
    protected $response;

    /**
     * @var \ByRobots\WriteDown\API\MetaBuilder
     */
    protected $metaBuilder;

    /**
     * @var \ByRobots\WriteDown\Validator\ValidatorInterface
     */
    protected $validator;

    /**
     * @inheritDoc
     */
    public function index(array $filters = []) : array
    {
        $entities = $this->db->getRepository($this->entityRepo)->all($filters);
        return $this->response->build(
            $entities,
            true,
            $this->db->getRepository($this->entityRepo),
            $filters
        );
    }

    /**
     * @inheritDoc
     */
    public function read($entityID) : array
    {
        $entity = $this->db->getRepository($this->entityRepo)->findOneBy(['id' => $entityID]);
        if (!$entity) {
            return $this->response->build(['Not found.'], false);
        }

        return $this->response->build($entity, true, $this->db->getRepository($this->entityRepo));
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes) : array
    {
        // Create the entity by looping through the attributes and populating
        // fillable ones
        $entity = 'ByRobots\WriteDown\Database\Entities\\' . $this->entity;
        $entity = new $entity;
        foreach ($attributes as $column => $value) {
            if (in_array($column, $entity->fillable)) {
                $entity->$column = $value;
            }
        }

        // Validate it
        if (!$this->validator->validate($entity->rules, $entity->validationArray())) {
            return $this->response->build($this->validator->errors(), false);
        }

        // Save it
        $this->db->persist($entity);
        $this->db->flush();
        return $this->response->build($entity);
    }

    /**
     * @inheritDoc
     */
    public function update($entityID, array $attributes) : array
    {
        $entity = $this->db->getRepository($this->entityRepo)->findOneBy(['id' => $entityID]);
        if (!$entity) {
            return $this->response->build(['Not found.'], false);
        }

        // Populate entity attributes
        foreach ($attributes as $column => $value) {
            if (in_array($column, $entity->fillable)) {
                $entity->$column = $value;
            }
        }

        // Validate it
        if (!$this->validator->validate($entity->updateRules(), $entity->validationArray())) {
            return $this->response->build($this->validator->errors(), false);
        }

        // Commit to the database and continue
        $this->db->flush();
        return $this->response->build($entity);
    }
}
