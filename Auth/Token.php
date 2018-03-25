<?php

namespace Tests\Auth;

use Tests\TestCase;
use WriteDown\Auth\Token as Provider;

class Token extends TestCase
{
    /**
     * The token generator.
     *
     * @var \WriteDown\Auth\TokenInterface
     */
    private $token;

    /**
     * Set-up.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->token = new Provider;
    }

    /**
     * A token is generated on request.
     */
    public function testGeneratesToken()
    {
        $this->assertTrue(is_string($this->token->generate()));
    }
}
