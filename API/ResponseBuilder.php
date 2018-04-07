<?php

namespace WriteDown\API;

use WriteDown\Database\Interfaces\RepositoryInterface;

/**
 * Responsible for building a consistent API response.
 */
class ResponseBuilder
{
    /**
     * @var \WriteDown\API\MetaBuilder
     */
    private $metaBuilder;

    /**
     * Get going.
     *
     * @param \WriteDown\API\MetaBuilder $metaBuilder
     *
     * @return void
     */
    public function __construct(MetaBuilder $metaBuilder)
    {
        $this->metaBuilder = $metaBuilder;
    }

    /**
     * Return on object.
     *
     * @param mixed                                              $data
     * @param boolean                                            $success
     * @param \WriteDown\Database\Interfaces\RepositoryInterface $repository
     * @param array                                              $filters
     *
     * @return array
     */
    public function build($data, $success = true, RepositoryInterface $repository = null, array $filters = []) : array
    {
        return [
            'data'    => $data,
            'success' => $success,
            'meta'    => !is_null($repository) ? $this->metaBuilder->build($repository, $filters) : [],
        ];
    }
}
