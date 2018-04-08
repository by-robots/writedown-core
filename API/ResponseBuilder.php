<?php

namespace WriteDown\API;

use Doctrine\Common\Persistence\ObjectRepository;

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
     * @param mixed                                         $data
     * @param boolean                                       $success
     * @param \Doctrine\Common\Persistence\ObjectRepository $repository
     * @param array                                         $filters
     *
     * @return array
     */
    public function build($data, $success = true, ObjectRepository $repository = null, array $filters = []) : array
    {
        return [
            'data'    => $data,
            'success' => $success,
            'meta'    => !is_null($repository) ? $this->metaBuilder->build($repository, $filters) : [],
        ];
    }
}
