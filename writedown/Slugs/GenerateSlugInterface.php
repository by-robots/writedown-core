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
    public function slug($input) : string;

    /**
     * Check if the given slug is unique.
     *
     * @param string $slug
     *
     * @return boolean
     */
    public function isUnique($slug) : bool;

    /**
     * Generate a unique slug based on the post's title.
     *
     * @param string $title
     *
     * @return string
     */
    public function uniqueSlug($title) : string;

    /**
     * Check if the given slug is unique, or that it belongs to the given Post ID.
     *
     * @param string  $slug
     * @param integer $postID
     *
     * @return boolean
     */
    public function isUniqueExcept($slug, $postID) : bool;
}
