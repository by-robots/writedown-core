<?php

namespace WriteDown\Auth;

use Doctrine\ORM\EntityManagerInterface;
use WriteDown\Auth\Interfaces\AuthInterface;

class Auth implements AuthInterface
{
    /**
     * Generates tokens.
     *
     * @var \WriteDown\Auth\Interfaces\TokenInterface
     */
    private $token;

    /**
     * Verifies credentials.
     *
     * @var \WriteDown\Auth\Interfaces\VerifyCredentialsInterface
     */
    private $verifyCredentials;

    /**
     * Verify authentication tokens.
     *
     * @var \WriteDown\Auth\Interfaces\VerifyTokenInterface
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
        $this->token             = new Token;
        $this->verifyCredentials = new VerifyCredentials($database);
        $this->verifyToken       = new VerifyToken($database);
    }

    /**
     * @inheritDoc
     */
    public function generate($length = 64) : string
    {
        return $this->token->generate();
    }

    /**
     * @inheritDoc
     */
    public function verifyCredentials($email, $password) : bool
    {
        return $this->verifyCredentials->verify($email, $password);
    }

    /**
     * @inheritDoc
     */
    public function verifyToken($token) : bool
    {
        return $this->verifyToken->verify($token);
    }
}
