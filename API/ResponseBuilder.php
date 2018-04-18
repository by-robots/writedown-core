<?php

namespace WriteDown\API;

use Doctrine\Common\Persistence\ObjectRepository;
use WriteDown\API\Interfaces\TransformerInterface;

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
     * @var \WriteDown\API\Interfaces\TransformerInterface
     */
    private $transformer;

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
     * Set the transformer.
     *
     * @param \WriteDown\API\Interfaces\TransformerInterface $transformer
     *
     * @return void
     */
    public function setTransformer(TransformerInterface $transformer)
    {
        $this->transformer = $transformer;
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
            'data'    => $success ? $this->formatData($data) : $data,
            'success' => $success,
            'meta'    => !is_null($repository) ?
                $this->metaBuilder->build($repository, $filters) : [],
        ];
    }

    /**
     * Build the response data in the correct format.
     *
     * @param mixed $data
     *
     * @return mixed
     */
    private function formatData($data)
    {
        // A single item
        if (is_object($data)) {
            return $this->transformer->transform($data);
        }

        // A collection of items
        $array = [];
        foreach ($data as $entry) {
            $array[] = $this->transformer->transform($entry);
        }

        return $array;
    }
}
