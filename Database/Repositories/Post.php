<?php

namespace WriteDown\Database\Repositories;

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

        $this->entity         = 'WriteDown\Database\Entities\Post';
        $this->defaultFilters = [
            'orderBy' => ['e.publish_at' => 'DESC'],
            'where'   => [
                'e.publish_at IS NOT NULL AND e.publish_at <= :now' => [
                    'now' => new \DateTime('now'),
                ],
            ],
        ];
    }
}
