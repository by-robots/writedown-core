<?php

namespace WriteDown\Auth;

class Token implements TokenInterface
{
    /**
     * Generate a secure token.
     *
     * @param int $length
     *
     * @return string
     */
    public function generate($length = 64)
    {
        return bin2hex(random_bytes($length));
    }
}
