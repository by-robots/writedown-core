<?php

namespace WriteDown\Database\Interfaces;

use Doctrine\ORM\QueryBuilder;

interface FilterInterface
{
    /**
     * Take a query builder instance and an array of filters to apply.
     *
     * @param \Doctrine\ORM\QueryBuilder $query
     * @param array                      $filters
     *
     * @return \Doctrine\ORM\QueryBuilder
     * @throws \Exception
     */
    public function build(QueryBuilder $query, array $filters) : QueryBuilder;
}
