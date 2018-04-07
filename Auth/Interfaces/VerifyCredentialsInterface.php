<?php

namespace WriteDown\Auth\Interfaces;

interface VerifyCredentialsInterface
{
    /**
     * Verify an email and password match.
     *
     * @param string $email
     * @param string $password
     *
     * @return bool
     */
    public function verify($email, $password) : bool;
}
