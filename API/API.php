<?php

namespace WriteDown\API;

use Doctrine\ORM\EntityManager;

class API
{
    /**
     * The EntityManager object.
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $db;

    /**
     * Set-up.
     *
     * @param Doctrine\ORM\EntityManager $database
     *
     * @return void
     */
    public function __construct(EntityManager $database)
    {
        $this->db = $database;
    }
}
