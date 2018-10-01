<?php

namespace ByRobots\WriteDown\Database\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use ByRobots\WriteDown\Database\Filter;
use ByRobots\WriteDown\Database\Interfaces\RepositoryInterface;

class BaseRepository extends EntityRepository implements RepositoryInterface
{
    /**
     * @var \ByRobots\WriteDown\Database\Interfaces\FilterInterface
     */
    protected $filter;

    /**
     * The entity the repository contains.
     *
     * @var string
     */
    protected $entity;

    /**
     * Contains default filters.
     *
     * @var array
     */
    protected $defaultFilters = [];

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

        $this->filter = new Filter;

        $this->defaultFilters['where']      = [];
        $this->defaultFilters['orderBy']    = [];
        $this->defaultFilters['pagination'] = [
            'current_page' => 1,
            'per_page'     => env('MAX_ITEMS', 10),
        ];
    }

    /**
     * @inheritDoc
     */
    public function all(array $filters = []) : array
    {
        // Combine $filters with the defaults, overriding the default ones with
        // those that have been passed directly.
        //
        // TODO: Re-factor this for tidiness
        $filters['where'] = isset($filters['where'])
            ? $filters['where'] : $this->defaultFilters['where'];

        $filters['pagination'] = isset($filters['pagination'])
            ? $filters['pagination'] : $this->defaultFilters['pagination'];

        $filters['orderBy'] = isset($filters['orderBy'])
            ? $filters['orderBy'] : $this->defaultFilters['orderBy'];

        // Build the start of the query
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('e')->from($this->entity, 'e');

        // Apply filters
        return $this->filter->build($query, $filters)->getQuery()->getResult();
    }

    /**
     * @inheritDoc
     */
    public function getCount() : int
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('count(e.id)')->from($this->entity, 'e')
            ->getQuery()->getSingleScalarResult();
    }
}
