<?php

namespace ByRobots\WriteDown\API;

use ByRobots\WriteDown\API\Interfaces\EndpointInterface;

/**
 * Implement the delete by a primary key method. Add this to the CRU methods.
 *
 * Not every endpoint can use this delete method so I've split it off for a bit
 * more granularity.
 */
class CRUD extends CRU implements EndpointInterface
{
    /**
     * @inheritDoc
     */
    public function delete($entityID):array
    {
        $entity = $this->db
            ->getRepository($this->entityRepo)
            ->findOneBy(['id' => $entityID]);

        if (!$entity) {
            return $this->response->build(['Not found.'], false);
        }

        $this->db->remove($entity);
        $this->db->flush();
        return $this->response->build([]);
    }
}
