<?php

namespace WriteDown\API\Transformers;

use WriteDown\API\Interfaces\TransformerInterface;

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
