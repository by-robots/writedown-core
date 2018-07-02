<?php

namespace ByRobots\WriteDown\API\Transformers;

use ByRobots\WriteDown\API\Interfaces\TransformerInterface;

class TagTransformer implements TransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform($entity): \stdClass
    {
        $tag        = new \stdClass;
        $tag->id    = $entity->id;
        $tag->name  = $entity->name;

        return $tag;
    }
}
