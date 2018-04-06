<?php

namespace WriteDown\Auth;

use WriteDown\Auth\Interfaces\TokenInterface;

class Token implements TokenInterface
{
    /**
     * @inheritDoc
     */
    public function generate($length = 64)
    {
        return bin2hex(random_bytes($length));
    }
}
