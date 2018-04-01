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
     * Checks whether a CSRF token is valid.
     *
     * @param string $value The token value.
     *
     * @return bool
     * @throws \Exception
     */
    public function isValid($value)
    {
        if (is_null($this->session->get($this->tokenName))) {
            throw new \Exception('No CSRF token set.');
        }

        return hash_equals($value, $this->get());
    }

    /**
     * Generate a token.
     *
     * @return void
     */
    public function generate()
    {
        $hash = hash('sha512', $this->token->generate());
        $this->session->set($this->tokenName, $hash);
    }

    /**
     * Get the generated token.
     *
     * @return string
     */
    public function get()
    {
        return $this->session->get($this->tokenName);
    }
}
