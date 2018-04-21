<?php

namespace Tests\Auth;

use Tests\TestCase;
use ByRobots\WriteDown\Auth\VerifyCredentials as Provider;

class VerifyCredentials extends TestCase
{
    /**
     * Validates user credentials.
     *
     * @var \ByRobots\WriteDown\Auth\Interfaces\VerifyCredentialsInterface
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
     * When the username and password match, the matching user should be
     * returned.
     */
    public function testGoodDetails()
    {
        // Create a new user, ensure we know the password
        $password = $this->faker->word;
        $user     = $this->writedown->api()->user()->create([
            'email'    => $this->faker->email,
            'password' => $password,
        ]);

        // Attempt to login with the correct details and check that it passes
        $loggedInUser = $this->auth->verify($user['data']->email, $password);
        $this->assertEquals($user['data']->email, $loggedInUser->email);
    }

    /**
     * When the password is wrong false should be returned
     */
    public function testBadPassword()
    {
        $user = $this->writedown->api()->user()->create([
            'email'    => $this->faker->email,
            'password' => $this->faker->word,
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
            'password' => $password,
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

    /**
     * Test that extra users can login.
     */
    public function testExtraUsers()
    {
        $this->resources->user();

        // Create a second user, ensure we know the password
        $password = $this->faker->word;
        $user     = $this->writedown->api()->user()->create([
            'email'    => $this->faker->email,
            'password' => $password,
        ]);

        // Attempt to login with the correct details and check that it passes
        $loggedInUser = $this->auth->verify($user['data']->email, $password);
        $this->assertEquals($user['data']->email, $loggedInUser->email);
    }
}
