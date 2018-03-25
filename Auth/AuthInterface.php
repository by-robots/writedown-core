<?php

namespace WriteDown\Auth;

interface AuthInterface
{
    /**
     * Verify an email and password match.
     *
     * @param string $email
     * @param string $password
     *
     * @return bool
     */
    public function verify($email, $password);
}
