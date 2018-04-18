<?php

namespace Tests\Auth;

use Tests\TestCase;
use WriteDown\Auth\VerifyToken as Provider;

class VerifyToken extends TestCase
{
    /**
     * The class responsible for verifying tokens.
     *
     * @var \WriteDown\Auth\Interfaces\VerifyTokenInterface
     */
    private $auth;

    /**
     * Set-up for testing.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->auth = new Provider($this->writedown->database());
    }

    /**
     * When the token matches true should be returned.
     */
    public function testGoodDetails()
    {
        // Create a new user, ensure we know the password
        $token = bin2hex(random_bytes(64));
        $this->writedown->api()->user()->create([
            'email'    => $this->faker->email,
            'password' => $this->faker->word,
            'token'    => $token,
        ]);

        // Attempt to login with the correct details and check that it passes
        $this->assertTrue($this->auth->verify($token));
    }

    /**
     * When the token is wrong false should be returned
     */
    public function testBadToken()
    {
        $this->writedown->api()->user()->create([
            'email'    => $this->faker->email,
            'password' => $this->faker->word,
            'token'    => bin2hex(random_bytes(64)),
        ]);

        // Attempt to login with the correct details and check that it passes
        $this->assertFalse($this->auth->verify(bin2hex(random_bytes(64))));
    }

    /**
     * When no token is set on the user, false should be returned.
     */
    public function testNoToken()
    {
        $this->resources->user();
        $this->assertFalse($this->auth->verify(bin2hex(random_bytes(64))));
    }
}
