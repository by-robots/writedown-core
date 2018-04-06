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
    public function verify($email, $password)
    {
        // Get the user by the email address
        $user = $this->db->getRepository('WriteDown\Database\Entities\User')
            ->findOneBy(['email' => $email]);

        if (!$user) {
            return false;
        }

        return password_verify($password, $user->password);
    }
}
