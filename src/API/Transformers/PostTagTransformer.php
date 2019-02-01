<?php

namespace ByRobots\WriteDown\API\Transformers;

use ByRobots\WriteDown\API\Interfaces\TransformerInterface;

class PostTagTransformer implements TransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform($entity):\stdClass
    {
        return new \stdClass;
    }
}
