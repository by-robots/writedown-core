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
        return !$this->db->getRepository('WriteDown\Database\Entities\Post')
            ->findOneBy(['slug' => $slug]) ? true : false;
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
        $result = $this->db->getRepository('WriteDown\Database\Entities\Post')
            ->findOneBy(['slug' => $slug]);

        if (!$result) {
            return true;
        }

        return $result->id == $postID ? true : false;
    }
}
