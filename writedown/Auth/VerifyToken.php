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
    private $database;

    /**
     * Set-up.
     *
     * @param \Doctrine\ORM\EntityManager $database
     *
     * @return void
     */
    public function __construct(EntityManager $database)
    {
        $this->database = $database;
    }

    /**
     * Verify a token is valid.
     *
     * @param string $token
     *
     * @return bool
     */
    public function verify($token) : bool
    {
        // Get the user by the email address
        $user = $this->database->getRepository('WriteDown\Database\Entities\User')
            ->findOneBy(['token' => $token]);

        return !$user ? false : true;
    }
}
