<?php

namespace ByRobots\WriteDown\Slugs;

use Doctrine\ORM\EntityManager;

class GenerateSlug implements GenerateSlugInterface
{
    /**
     * Generate slug.
     *
     * @var \ByRobots\WriteDown\Slugs\Slugger
     */
    private $slugger;

    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager $database
     *
     * @return void
     */
    public function __construct(EntityManager $database)
    {
        $this->slugger = new Slugger;
    }

    /**
     * @inheritDoc
     */
    public function slug($input) : string
    {
        return $this->slugger->slug($input);
    }
}
