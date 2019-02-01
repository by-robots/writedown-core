<?php

namespace Tests\CSRF\Hash;

use Tests\Stubs\SessionStub;
use Tests\TestCase;
use ByRobots\WriteDown\Auth\Token;
use ByRobots\WriteDown\CSRF\Hash;

class Gets extends TestCase
{
    /**
     * @var \ByRobots\WriteDown\CSRF\CSRFInterface $csrf
     */
    private $csrf;

    /**
     * Set-up the tests.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->csrf = new Hash(new SessionStub, new Token);
    }

    /**
     * The get method should return null when no token has been generated.
     */
    public function testNoToken()
    {
        $this->assertNull($this->csrf->get());
    }

    /**
     * The get method should return a generated token.
     */
    public function testToken()
    {
        $this->csrf->generate();
        $this->assertNotNull($this->csrf->get());
    }
}
