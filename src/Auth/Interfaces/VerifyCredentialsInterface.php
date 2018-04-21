<?php

namespace ByRobots\WriteDown\Auth\Interfaces;

interface VerifyCredentialsInterface
{
    /**
     * Verify an email and password match.
     *
     * @param string $email
     * @param string $password
     *
     * @return \ByRobots\WriteDown\Database\Entities\User|bool
     */
    public function verify($email, $password);
}
