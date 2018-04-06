<?php

namespace WriteDown\CSRF;

use WriteDown\Auth\Interfaces\TokenInterface;
use WriteDown\Sessions\SessionInterface;

class Hash implements CSRFInterface
{
    /**
     * For writing the token the the session.
     *
     * @var \WriteDown\Sessions\SessionInterface
     */
    private $session;

    /**
     * Gor generating token.
     *
     * @var \WriteDown\Auth\Interfaces\TokenInterface
     */
    private $token;

    /**
     * Session name to store the token in.
     *
     * @var string
     */
    private $tokenName = 'csrf_token';

    /**
     * Set-up the class.
     *
     * @param \WriteDown\Sessions\SessionInterface      $session
     * @param \WriteDown\Auth\Interfaces\TokenInterface $token
     *
     * @return void
     */
    public function __construct(SessionInterface $session, TokenInterface $token)
    {
        $this->session = $session;
        $this->token   = $token;
    }

    /**
     * @inheritDoc
     */
    public function isValid($value)
    {
        if (is_null($this->session->get($this->tokenName))) {
            throw new \Exception('No CSRF token set.');
        }

        return hash_equals($value, $this->get());
    }

    /**
     * @inheritDoc
     */
    public function generate()
    {
        $hash = hash('sha512', $this->token->generate());
        $this->session->set($this->tokenName, $hash);
    }

    /**
     * @inheritDoc
     */
    public function get()
    {
        return $this->session->get($this->tokenName);
    }
}
