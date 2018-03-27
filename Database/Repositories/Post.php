<?php

namespace WriteDown\Database\Repositories;

use Doctrine\ORM\EntityRepository;

class Post extends EntityRepository
{
    public function findAll()
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('p')->from('WriteDown\Database\Entities\Post', 'p')
            ->where('p.publish_at IS NOT NULL AND p.publish_at <= :now')
            ->orderBy('p.publish_at', 'DESC')
            ->setParameter('now', new \DateTime('now'));

        return $query->getQuery()->getResult();
    }
}
