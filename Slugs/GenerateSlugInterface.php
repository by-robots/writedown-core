<?php

namespace WriteDown\Slugs;

interface GenerateSlugInterface
{
    /**
     * Take a string and convert it to a URL friendly slug.
     *
     * @param string $input
     *
     * @return string
     */
    public function slug($input);

    /**
     * Check if the given slug is unique.
     *
     * @param string $slug
     *
     * @return boolean
     */
    public function isUnique($slug);

    /**
     * Generate a unique slug based on the post's title.
     *
     * @param string $title
     *
     * @return string
     */
    public function uniqueSlug($title);
}
