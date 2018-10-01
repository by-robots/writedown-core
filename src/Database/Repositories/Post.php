<?php

namespace ByRobots\WriteDown\Database\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;

class Post extends BaseRepository
{
    /**
     * Lock S-Foils in attack position.
     *
     * @param \Doctrine\ORM\EntityManager         $em
     * @param \Doctrine\ORM\Mapping\ClassMetadata $class
     *
     * @return void
     */
    public function __construct(EntityManager $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);

        $this->entity = 'ByRobots\WriteDown\Database\Entities\Post';

        $this->defaultFilters['orderBy'] = ['e.publish_at' => 'DESC'];
        $this->defaultFilters['where']   = [
            'e.detached = :post_detached' => ['post_detached' => false],
            'e.publish_at IS NOT NULL AND e.publish_at <= :post_now' => [
                'post_now' => new \DateTime('now'),
            ],
        ];
    }
}
