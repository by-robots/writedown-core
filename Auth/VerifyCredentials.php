<?php

namespace Tests\Auth;

use Tests\TestCase;
use WriteDown\Auth\VerifyCredentials as Provider;

class VerifyCredentials extends TestCase
{
    /**
     * Validates user credentials.
     *
     * @var \WriteDown\Auth\VerifyCredentialsInterface
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
     * When the username and password match, true should be returned.
     */
    public function testGoodDetails()
    {
        // Create a new user, ensure we know the password
        $password = $this->faker->word;
        $user     = $this->writedown->api()->user()->create([
            'email'    => $this->faker->email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        // Attempt to login with the correct details and check that it passes
        $this->assertTrue($this->auth->verify($user['data']->email, $password));
    }

    /**
     * When the password is wrong false should be returned
     */
    public function testBadPassword()
    {
        $user = $this->writedown->api()->user()->create([
            'email'    => $this->faker->email,
            'password' => password_hash($this->faker->word, PASSWORD_DEFAULT),
        ]);

        // Attempt to login with the correct details and check that it passes
        $this->assertFalse($this->auth->verify($user['data']->email, $this->faker->word));
    }

    /**
     * When the email is wrong false should be returned.
     */
    public function testBadEmail()
    {
        // Create a new user, ensure we know the password
        $password = $this->faker->word;
        $this->writedown->api()->user()->create([
            'email'    => $this->faker->email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        // Attempt to login with the correct details and check that it passes
        $this->assertFalse($this->auth->verify($this->faker->email, $password));
    }

    /**
     * When both the email and password are wrong false should be returned
     */
    public function testEmailAndPasswordBad()
    {
        // Create a new user
        $this->resources->user();

        // Attempt to login with the correct details and check that it passes
        $this->assertFalse($this->auth->verify($this->faker->email, $this->faker->word));
    }
}
