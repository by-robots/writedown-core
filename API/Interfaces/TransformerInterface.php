<?php

namespace WriteDown\API\Interfaces;

interface TransformerInterface
{
    /**
     * Take an entity and transform it to a simpler object.
     *
     * @param mixed $entity
     *
     * @return \stdClass
     */
    public function transform($entity) : \stdClass;
}
