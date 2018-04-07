<?php

namespace WriteDown\Auth;

use Doctrine\ORM\EntityManager;
use WriteDown\Auth\Interfaces\VerifyTokenInterface;

class VerifyToken implements VerifyTokenInterface
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
     * @inheritDoc
     */
    public function verify($token) : bool
    {
        // Get the user by the email address
        $user = $this->db->getRepository('WriteDown\Database\Entities\User')
            ->findOneBy(['token' => $token]);

        return !$user ? false : true;
    }
}
