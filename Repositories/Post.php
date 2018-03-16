<?php

namespace WriteDown\Repositories;

use Doctrine\ORM\EntityRepository;

class Post extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy([], ['publish_at' => 'DESC']);
    }
}
