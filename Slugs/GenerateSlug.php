<?php

namespace WriteDown\Slugs;

use Doctrine\ORM\EntityManager;
use WriteDown\Slugs\Tools\Slugger;
use WriteDown\Slugs\Tools\UniqueSlug;

class GenerateSlug implements GenerateSlugInterface
{
    /**
     * Generate slug.
     *
     * @var \WriteDown\Slugs\Tools\Slugger
     */
    private $slugger;

    /**
     * Check slugs are unique.
     *
     * @var \WriteDown\Slugs\Tools\UniqueSlug
     */
    private $uniqueSlug;

    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager $database
     *
     * @return void
     */
    public function __construct(EntityManager $database)
    {
        $this->slugger    = new Slugger;
        $this->uniqueSlug = new UniqueSlug($database);
    }

    /**
     * Take a string and convert it to a URL friendly slug.
     *
     * @param string $input
     *
     * @return string
     */
    public function slug($input)
    {
        return $this->slugger->slug($input);
    }

    /**
     * Check if the given slug is unique.
     *
     * @param string $slug
     *
     * @return boolean
     */
    public function isUnique($slug)
    {
        return $this->uniqueSlug->isUnique($slug);
    }

    /**
     * Generate a unique slug based on the post's title.
     *
     * @param string $title
     *
     * @return string
     */
    public function uniqueSlug($title)
    {
        $index = 0;

        do {
            $slug = $this->slug($title);
            $index++;

            if ($index > 1) {
                $slug .= '-' . $index;
            }
        } while (!$this->isUnique($slug));

        return $slug;
    }

    /**
     * Check if the given slug is unique, or that it belongs to the given Post ID.
     *
     * @param string  $slug
     * @param integer $postID
     *
     * @return boolean
     */
    public function isUniqueExcept($slug, $postID)
    {
        return $this->uniqueSlug->isUniqueExcept($slug, $postID);
    }
}
