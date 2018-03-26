<?php

namespace WriteDown\Auth;

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
