<?php

namespace WriteDown\Database\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use WriteDown\Database\Filter;

class BaseRepository extends EntityRepository
{
    /**
     * @var \WriteDown\Database\Interfaces\FilterInterface
     */
    protected $filter;

    /**
     * Contains default filters.
     *
     * @var array
     */
    protected $defaultFilters;

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
}
