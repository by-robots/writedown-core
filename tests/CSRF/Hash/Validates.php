<?php

namespace Tests\CSRF\Hash;

use Tests\Stubs\SessionStub;
use Tests\TestCase;
use WriteDown\Auth\Token;
use WriteDown\CSRF\Hash;

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
        $this->csrf = new Hash(new SessionStub, new Token);
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
