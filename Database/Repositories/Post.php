<?php

namespace WriteDown\Database\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use WriteDown\Database\Interfaces\RepositoryInterface;

class Post extends BaseRepository implements RepositoryInterface
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
            'orderBy' => ['p.publish_at' => 'DESC'],
            'where'   => [
                'p.publish_at IS NOT NULL AND p.publish_at <= :now' => [
                    'now' => new \DateTime('now'),
                ],
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function all(array $filters = [])
    {
        // Combine $filters with the default, overriding the default ones with
        // those that have been passed directly.
        $filters = array_merge($this->defaultFilters, $filters);

        // Build the start of the query
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from($this->entity, 'p');

        // Apply filters
        return $this->filter->build($query, $filters)->getQuery()->getResult();
    }
}
