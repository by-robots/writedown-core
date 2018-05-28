<?php

namespace ByRobots\WriteDown\API\Interfaces;

interface EndpointInterface extends EndpointCRUInterface
{
    /**
     * Delete an entity.
     *
     * @param int $entityID
     *
     * @return array
     */
    public function delete($entityID) : array;
}
