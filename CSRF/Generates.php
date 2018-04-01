<?php

namespace Tests\CSRF;

use Tests\Stubs\SessionStub;
use Tests\TestCase;

class Generates extends TestCase
{
    /**
     * Set-up the tests.
     */
    public function setUp()
    {
        parent::setUp();
        $this->writedown->getContainer()
            ->add('WriteDown\Sessions\SessionInterface', SessionStub::class);

        $this->csrf = $this->writedown->csrf();
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
