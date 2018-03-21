<?php

namespace WriteDown\API;

interface EndpointInterface
{
    /**
     * List all entities.
     *
     * @return array
     */
    public function index();

    /**
     * Retrieve a single entity by it's ID.
     *
     * @param int $entityID
     *
     * @return array
     */
    public function read($entityID);

    /**
     * Create a new entity.
     *
     * @param array $attributes
     *
     * @return array
     */
    public function create(array $attributes);

    /**
     * Update an entity.
     *
     * @param int   $entityID
     * @param array $attributes
     *
     * @return array
     */
    public function update($entityID, array $attributes);

    /**
     * Delete an entity.
     *
     * @param int $entityID
     *
     * @return array
     */
    public function delete($entityID);
}