<?php

namespace Tests\CSRF;

use Tests\Stubs\SessionStub;
use Tests\TestCase;

class Validates extends TestCase
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
     * If the token matches that in the session the class should return true.
     */
    public function testValid()
    {
        // Generate a token and retrieve it
        $this->csrf->generate();
        $token = $this->csrf->get();

        // Now check it validates correctly
        $this->assertTrue($this->csrf->isValid($token));
    }

    /**
     * If the token does not match false should be returned.
     */
    public function testInvalid()
    {
        $this->csrf->generate();
        $this->assertFalse($this->csrf->isValid('Tm90aGluZyBidXQgdGhlIHJhaW4u'));
    }

    /**
     * When no taken is set, isValid should throw an exception.
     *
     * @expectedException \Exception
     */
    public function testNoTokenGenerated()
    {
        $this->csrf->isValid('SSBBbSBUaGUgT25lIFdobyBLbm9ja3M=');
    }
}
