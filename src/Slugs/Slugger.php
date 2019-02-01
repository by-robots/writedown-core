<?php

namespace ByRobots\WriteDown\Slugs;

use Doctrine\ORM\EntityManager;

class Slugger implements GenerateSlugInterface
{
    /**
     * Generate slug.
     *
     * @var \ByRobots\WriteDown\Slugs\GenerateSlug
     */
    private $generateSlug;

    /**
     * Check slugs are unique.
     *
     * @var \ByRobots\WriteDown\Slugs\UniqueSlug
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
        $this->generateSlug = new GenerateSlug;
        $this->uniqueSlug   = new UniqueSlug($database);
    }

    /**
     * @inheritDoc
     */
    public function generateSlug($input):string
    {
        return $this->generateSlug->slug($input);
    }

    /**
     * @inheritDoc
     */
    public function isUnique($slug):bool
    {
        return $this->uniqueSlug->isUnique($slug);
    }

    /**
     * @inheritDoc
     */
    public function uniqueSlug($title):string
    {
        $index = 0;

        do {
            $slug = $this->generateSlug($title);
            $index++;

            if ($index > 1) {
                $slug .= '-' . $index;
            }
        } while (!$this->isUnique($slug));

        return $slug;
    }
}
