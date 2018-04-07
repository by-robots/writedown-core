<?php

namespace WriteDown\Database\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use WriteDown\Database\Filter;
use WriteDown\Database\Interfaces\RepositoryInterface;

class BaseRepository extends EntityRepository implements RepositoryInterface
{
    /**
     * @var \WriteDown\Database\Interfaces\FilterInterface
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
            ->select('e')
            ->from($this->entity, 'e');

        // Apply filters
        return $this->filter->build($query, $filters)->getQuery()->getResult();
    }

    /**
     * Get the total rows for the repository.
     *
     * @return int
     * @throws \Exception
     */
    public function getCount() : int
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('count(e.id)')->from($this->entity, 'e')
            ->getQuery()->getSingleScalarResult();
    }
}
