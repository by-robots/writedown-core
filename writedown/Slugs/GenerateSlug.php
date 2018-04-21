<?php

namespace WriteDown\Slugs;

use Doctrine\ORM\EntityManager;

class GenerateSlug implements GenerateSlugInterface
{
    /**
     * Generate slug.
     *
     * @var \WriteDown\Slugs\Slugger
     */
    private $slugger;

    /**
     * Check slugs are unique.
     *
     * @var \WriteDown\Slugs\UniqueSlug
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
     * @inheritDoc
     */
    public function slug($input) : string
    {
        return $this->slugger->slug($input);
    }

    /**
     * @inheritDoc
     */
    public function isUnique($slug) : bool
    {
        return $this->uniqueSlug->isUnique($slug);
    }

    /**
     * @inheritDoc
     */
    public function uniqueSlug($title) : string
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
     * @inheritDoc
     */
    public function isUniqueExcept($slug, $postID) : bool
    {
        return $this->uniqueSlug->isUniqueExcept($slug, $postID);
    }
}
