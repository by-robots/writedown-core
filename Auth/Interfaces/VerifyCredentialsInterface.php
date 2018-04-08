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
     * @return \WriteDown\Database\Entities\User
     */
    public function verify($email, $password);
}
