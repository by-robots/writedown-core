<?php

namespace Tests\CSRF;

use Tests\Stubs\SessionStub;
use Tests\TestCase;

class Gets extends TestCase
{
    /**
     * @var \WriteDown\CSRF\CSRFInterface $csrf
     */
    private $csrf;

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
