<?php

namespace WriteDown\Auth;

use Doctrine\ORM\EntityManager;
use WriteDown\Auth\Interfaces\VerifyCredentialsInterface;

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
     * Verify an email and password match.
     *
     * @param string $email
     * @param string $password
     *
     * @return bool
     */
    public function verify($email, $password) : bool
    {
        // Get the user by the email address
        $user = $this->database->getRepository('WriteDown\Database\Entities\User')
            ->findOneBy(['email' => $email]);

        if (!$user) {
            return false;
        }

        return password_verify($password, $user->password);
    }
}
