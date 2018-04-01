<?php

namespace WriteDown\CSRF;

interface CSRFInterface
{
    /**
     * Checks whether a CSRF token is valid.
     *
     * @param string $value The token value.
     *
     * @return bool
     * @throws \Exception
     */
    public function isValid($value);

    /**
     * Generate a token.
     *
     * @return void
     */
    public function generate();

    /**
     * Get the generated token.
     *
     * @return string|null
     */
    public function get();
}
