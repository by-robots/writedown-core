<?php

namespace WriteDown\API;

use WriteDown\Slugs\GenerateSlugInterface;

interface APIInterface
{
    /**
     * Work with posts.
     *
     * @param \WriteDown\Slugs\GenerateSlugInterface $generateSlug
     *
     * @return \WriteDown\API\EndpointInterface;
     */
    public function post(GenerateSlugInterface $generateSlug);
}
