<?php

namespace Tests\Auth;

use Tests\TestCase;
use ByRobots\WriteDown\Auth\Token as Provider;

class Token extends TestCase
{
    /**
     * The token generator.
     *
     * @var \ByRobots\WriteDown\Auth\Interfaces\TokenInterface
     */
    private $token;

    /**
     * Set-up.
     *
     * @return void
     */
    public function setUp(): void
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
