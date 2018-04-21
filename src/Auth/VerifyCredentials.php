<?php

namespace ByRobots\WriteDown\Auth;

use Doctrine\ORM\EntityManager;
use ByRobots\WriteDown\Auth\Interfaces\VerifyCredentialsInterface;
use ByRobots\WriteDown\Database\Entities\User;

class VerifyCredentials implements VerifyCredentialsInterface
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
     * @inheritdoc
     */
    public function verify($email, $password)
    {
        // Get the user by the email address
        $user = $this->database
            ->getRepository('ByRobots\WriteDown\Database\Entities\User')
            ->findOneBy(['email' => $email]);

        if (!$user or !password_verify($password, $user->password)) {
            return false;
        }

        return $user;
    }
}
