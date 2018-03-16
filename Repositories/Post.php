<?php

namespace WriteDown\Repositories;

use Doctrine\ORM\EntityRepository;

class Post extends EntityRepository
{
    public function findAll()
    {
        $query = $this->getEntityManager()
            ->createQuery('SELECT p FROM WriteDown\Entities\Post p
                ORDER BY p.publish_at DESC');

        return $query->getResult();
    }
}
