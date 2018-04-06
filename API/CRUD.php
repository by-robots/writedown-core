<?php

namespace WriteDown\API;

use WriteDown\API\Interfaces\EndpointInterface;

class CRUD implements EndpointInterface
{
    /**
     * The entity repo.
     *
     * @var string
     */
    protected $entityRepo;

    /**
     * The entity class name.
     *
     * @var string
     */
    protected $entity;

    /**
     * The EntityManager.
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $db;

    /**
     * Builds API responses.
     *
     * @var \WriteDown\API\ResponseBuilder
     */
    protected $response;

    /**
     * Validates data.
     *
     * @var \WriteDown\Validator\ValidatorInterface
     */
    protected $validator;

    /**
     * @inheritDoc
     */
    public function index(array $modifiers = [])
    {
        $entities = $this->db->getRepository($this->entityRepo)->findAll();
        return $this->response->build($entities);
    }

    /**
     * @inheritDoc
     */
    public function read($entityID)
    {
        $entity = $this->db->getRepository($this->entityRepo)->findOneBy(['id' => $entityID]);
        if (!$entity) {
            return $this->response->build(['Not found.'], false);
        }

        return $this->response->build($entity);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes)
    {
        // Create the entity by looping through the attributes and populating
        // fillable ones
        $entity = 'WriteDown\Database\Entities\\' . $this->entity;
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
    public function update($entityID, array $attributes)
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

        // Commit to the database and continue
        $this->db->flush();
        return $this->response->build($entity);
    }

    /**
     * @inheritDoc
     */
    public function delete($entityID)
    {
        $entity = $this->db->getRepository($this->entityRepo)->findOneBy(['id' => $entityID]);
        if (!$entity) {
            return $this->response->build(['Not found.'], false);
        }

        $this->db->remove($entity);
        $this->db->flush();
        return $this->response->build([]);
    }
}
