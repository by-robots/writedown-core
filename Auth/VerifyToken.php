<?php

namespace WriteDown\Auth;

use Doctrine\ORM\EntityManager;

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
     * Verify an email and password match.
     *
     * @param string $token
     *
     * @return bool
     */
    public function verify($token)
    {
        // Get the user by the email address
        $user = $this->db->getRepository('WriteDown\Entities\User')
            ->findOneBy(['token' => $token]);

        return !$user ? false : true;
    }
}
