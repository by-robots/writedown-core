<?php

namespace ByRobots\WriteDown\API;

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
    public function build(ObjectRepository $repository, array $filters):array
    {
        if (!isset($filters['pagination'])) {
            return [];
        }

        $resultCount = $repository->getCount();

        return [
            'current_page' => $filters['pagination']['current_page'] ?? 1,
            'per_page'     => $filters['pagination']['per_page']     ?? $resultCount,
            'total_pages'  => $resultCount == 0 ?
                0 :
                (isset($filters['pagination']['per_page']) ?
                    ceil($resultCount / $filters['pagination']['per_page']) : 1),
        ];
    }
}
