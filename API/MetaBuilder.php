<?php

namespace WriteDown\API;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Build meta data to be included with the API response.
 */
class MetaBuilder
{
    /**
     * Build the response.
     *
     * @param \Doctrine\Common\Persistence\ObjectRepository $repository
     * @param array                                         $filters
     *
     * @return array
     */
    public function build(ObjectRepository $repository, array $filters) : array
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
