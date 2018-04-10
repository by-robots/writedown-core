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
     * @return \WriteDown\Database\Entities\User|bool
     */
    public function verifyCredentials($email, $password);

    /**
     * Verify a token is valid.
     *
     * @param string $token
     *
     * @return bool
     */
    public function verifyToken($token) : bool;

    /**
     * Retrieve the logged in user.
     *
     * @param string $token
     *
     * @return \WriteDown\Database\Entities\User
     */
    public function user($token);
}
