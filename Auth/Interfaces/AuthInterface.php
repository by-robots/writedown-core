<?php

namespace WriteDown\Auth\Interfaces;

interface AuthInterface
{
    /**
     * Generate a secure token.
     *
     * @param int $length
     *
     * @return string
     * @throws \Exception
     */
    public function generate($length = 64) : string;

    /**
     * Verify an email and password match.
     *
     * @param string $email
     * @param string $password
     *
     * @return bool
     */
    public function verifyCredentials($email, $password) : bool;

    /**
     * Verify a token is valid.
     *
     * @param string $token
     *
     * @return bool
     */
    public function verifyToken($token) : bool;
}
