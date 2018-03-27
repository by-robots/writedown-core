<?php

namespace WriteDown\API\Interfaces;

use WriteDown\Slugs\GenerateSlugInterface;

interface APIInterface
{
    /**
     * Work with posts.
     *
     * @param \WriteDown\Slugs\GenerateSlugInterface $generateSlug
     *
     * @return \WriteDown\API\Interfaces\EndpointInterface;
     */
    public function post(GenerateSlugInterface $generateSlug);
}
