<?php

namespace WriteDown\API;

interface APIInterface
{
    /**
     * Work with posts.
     *
     * @return \WriteDown\API\EndpointInterface;
     */
    public function post();
}