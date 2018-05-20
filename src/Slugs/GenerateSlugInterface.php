<?php

namespace ByRobots\WriteDown\Slugs;

interface GenerateSlugInterface
{
    /**
     * Take a string and convert it to a URL friendly slug.
     *
     * @param string $input
     *
     * @return string
     */
    public function slug($input) : string;
}
