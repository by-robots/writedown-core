<?php

namespace WriteDown\API;

use WriteDown\Database\Interfaces\RepositoryInterface;

/**
 * Build meta data to be included with the API response.
 */
class MetaBuilder
{
    /**
     * Build the response.
     *
     * @param \WriteDown\Database\Interfaces\RepositoryInterface $repository
     * @param array                                              $filters
     *
     * @return array
     */
    public function build(RepositoryInterface $repository, array $filters) : array
    {
        if (!array_key_exists('pagination', $filters)) {
            return [];
        }

        return [
            'current_page' => $filters['pagination']['page'],
            'per_page'     => $filters['pagination']['per_page'],
            'total_pages'  => ceil(
                $repository->getCount() / $filters['pagination']['per_page']
            ),
        ];
    }
}
