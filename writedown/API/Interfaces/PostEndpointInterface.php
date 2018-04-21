<?php

namespace WriteDown\API\Interfaces;

interface PostEndpointInterface extends EndpointInterface
{
    /**
     * Retrieve a post by it's slug.
     *
     * @param string $slug
     *
     * @return array
     */
    public function bySlug($slug) : array;
}
