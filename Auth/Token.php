<?php

namespace WriteDown\Auth;

use WriteDown\Auth\Interfaces\TokenInterface;

class Token implements TokenInterface
{
    /**
     * Generate a secure token.
     *
     * @param int $length
     *
     * @return string
     * @throws \Exception
     */
    public function generate($length = 64) : string
    {
        return bin2hex(random_bytes($length));
    }
}
