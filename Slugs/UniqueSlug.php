<?php

namespace WriteDown\Slugs;

use Doctrine\ORM\EntityManager;

class UniqueSlug
{
    /**
     * The EntityManager object.
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $db;

    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager $database
     *
     * @return void
     */
    public function __construct(EntityManager $database)
    {
        $this->db = $database;
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
        return !$this->db->getRepository('WriteDown\Entities\Post')
            ->findOneBy(['slug' => $slug]) ? true : false;
    }
}
