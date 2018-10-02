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
        // Build the filters
        $filters = $this->mergeFilters($filters);

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

    /**
     * Build the complete filter by merging the defaults and any that have been
     * supplied.
     *
     * @param array $supplied
     *
     * @return array
     */
    private function mergeFilters(array $supplied) : array
    {
        $filters = [];
        $filters['where'] = isset($supplied['where'])
            ? $supplied['where'] : $this->defaultFilters['where'];

        $filters['pagination'] = isset($supplied['pagination'])
            ? $supplied['pagination'] : $this->defaultFilters['pagination'];

        $filters['orderBy'] = isset($supplied['orderBy'])
            ? $supplied['orderBy'] : $this->defaultFilters['orderBy'];

        return $filters;
    }
}
