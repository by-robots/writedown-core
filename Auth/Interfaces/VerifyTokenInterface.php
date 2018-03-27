<?php

namespace WriteDown\Auth\Interfaces;

interface VerifyTokenInterface
{
    /**
     * Verify a token is valid.
     *
     * @param string $token
     *
     * @return bool
     */
    public function verify($token);
}
