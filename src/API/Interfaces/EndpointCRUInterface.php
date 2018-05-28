<?php

namespace ByRobots\WriteDown\API\Interfaces;

/**
 * Define the Create, Read and Update methods.
 */
interface EndpointCRUInterface
{
    /**
     * List all entities.
     *
     * @param array $filters
     *
     * @return array
     */
    public function index(array $filters = []) : array;

    /**
     * Retrieve a single entity by it's ID.
     *
     * @param int $entityID
     *
     * @return array
     */
    public function read($entityID) : array;

    /**
     * Create a new entity.
     *
     * @param array $attributes
     *
     * @return array
     */
    public function create(array $attributes) : array;

    /**
     * Update an entity.
     *
     * @param int   $entityID
     * @param array $attributes
     *
     * @return array
     */
    public function update($entityID, array $attributes) : array;
}
