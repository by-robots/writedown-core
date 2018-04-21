<?php

namespace ByRobots\WriteDown\API\Transformers;

use ByRobots\WriteDown\API\Interfaces\TransformerInterface;

class UserTransformer implements TransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform($entity): \stdClass
    {
        $user        = new \stdClass;
        $user->id    = $entity->id;
        $user->email = $entity->email;

        return $user;
    }
}
