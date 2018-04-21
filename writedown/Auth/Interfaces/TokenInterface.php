<?php

namespace WriteDown\Auth\Interfaces;

interface TokenInterface
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
}
