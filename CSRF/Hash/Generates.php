<?php

namespace Tests\CSRF\Hash;

use Tests\Stubs\SessionStub;
use Tests\TestCase;
use WriteDown\Auth\Token;
use WriteDown\CSRF\Hash;

class Generates extends TestCase
{
    /**
     * Set-up the tests.
     */
    public function setUp()
    {
        parent::setUp();
        $this->csrf = new Hash(new SessionStub, new Token);
    }

    /**
     * The generate method should generate a token.
     */
    public function testGenerated()
    {
        $this->assertNull($this->csrf->get());

        $this->csrf->generate();
        $this->assertNotNull($this->csrf->get());
    }

    /**
     * The generate method should overwrite any existing values.
     */
    public function testOverwrites()
    {
        $this->csrf->generate();

        $generated = $this->csrf->get();
        $this->csrf->generate();

        $this->assertNotEquals($this->csrf->get(), $generated);
    }
}
