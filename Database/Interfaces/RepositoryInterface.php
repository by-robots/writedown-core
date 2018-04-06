<?php

namespace WriteDown\Database\Interfaces;


interface RepositoryInterface
{
    /**
     * Get all records, applying any filters.
     *
     * @param array $filters
     *
     * @return array
     */
    public function all(array $filters = []);
}
