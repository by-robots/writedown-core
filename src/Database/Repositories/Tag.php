<?php

namespace ByRobots\WriteDown\Database\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;

class Tag extends BaseRepository
{
    /**
     * Set-up the repository.
     *
     * @param \Doctrine\ORM\EntityManager         $em
     * @param \Doctrine\ORM\Mapping\ClassMetadata $class
     *
     * @return void
     */
    public function __construct(EntityManager $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->entity = 'ByRobots\WriteDown\Database\Entities\Tag';
    }
}
