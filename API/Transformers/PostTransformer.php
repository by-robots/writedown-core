<?php

namespace WriteDown\API\Transformers;

use WriteDown\API\Interfaces\TransformerInterface;

class PostTransformer implements TransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform($entity): \stdClass
    {
        $post             = new \stdClass;
        $post->id         = $entity->id;
        $post->title      = $entity->title;
        $post->slug       = $entity->slug;
        $post->excerpt    = $entity->excerpt;
        $post->body       = $entity->body;
        $post->publish_at = $entity->publish_at;

        return $post;
    }
}
