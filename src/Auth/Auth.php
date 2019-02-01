<?php

namespace ByRobots\WriteDown\Auth;

use Doctrine\ORM\EntityManagerInterface;
use ByRobots\WriteDown\Auth\Interfaces\AuthInterface;

class Auth implements AuthInterface
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $database;

    /**
     * Generates tokens.
     *
     * @var \ByRobots\WriteDown\Auth\Interfaces\TokenInterface
     */
    private $token;

    /**
     * Verifies credentials.
     *
     * @var \ByRobots\WriteDown\Auth\Interfaces\VerifyCredentialsInterface
     */
    private $verifyCredentials;

    /**
     * Verify authentication tokens.
     *
     * @var \ByRobots\WriteDown\Auth\Interfaces\VerifyTokenInterface
     */
    private $verifyToken;

    /**
     * Crank it.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $database
     *
     * @return void
     */
    public function __construct(EntityManagerInterface $database)
    {
        $this->database          = $database;
        $this->token             = new Token;
        $this->verifyCredentials = new VerifyCredentials($this->database);
        $this->verifyToken       = new VerifyToken($this->database);
    }

    /**
     * @inheritDoc
     */
    public function generate($length = 64):string
    {
        return $this->token->generate();
    }

    /**
     * @inheritDoc
     */
    public function verifyCredentials($email, $password)
    {
        return $this->verifyCredentials->verify($email, $password);
    }

    /**
     * @inheritDoc
     */
    public function verifyToken($token):bool
    {
        return $this->verifyToken->verify($token);
    }

    /**
     * @inheritDoc
     */
    public function user($token)
    {
        $user = $this->database
            ->getRepository('ByRobots\WriteDown\Database\Entities\User')
            ->findOneBy(['token' => $token]);

        return $user;
    }
}
