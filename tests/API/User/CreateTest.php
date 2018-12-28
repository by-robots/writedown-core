<?php

namespace Tests\API\User;

use Tests\TestCase;

class CreateTest extends TestCase
{
    /**
     * Tests that a user can be created when the data is valid.
     */
    public function testCreated()
    {
        // Create a user
        $email = $this->faker->email;
        $user  = $this->writedown->getService('api')->user()->create([
            'email'    => $email,
            'password' => $this->faker->word,
        ]);

        // Check we have something
        $this->assertTrue($user['success']);
        $this->assertEquals($email, $user['data']->email);
    }

    /**
     * Tests that a user can't be created without an email.
     */
    public function testValidationNoEmail()
    {
        // Attempt to create a user without an email.
        $result = $this->writedown->getService('api')->user()->create([
            'password' => $this->faker->word,
        ]);

        // Check the error was as expected
        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('email', $result['data']);
    }

    /**
     * Email must be valid.
     */
    public function testValidEmail()
    {
        // Create a user
        $user = $this->writedown->getService('api')->user()->create([
            'email'    => $this->faker->word,
            'password' => $this->faker->word,
        ]);

        // Check we have something
        $this->assertFalse($user['success']);
        $this->assertArrayHasKey('email', $user['data']);
    }

    /**
     * Test a user can not be created without a password.
     */
    public function testValidationNoPassword()
    {
        $result = $this->writedown->getService('api')->user()->create([
            'email' => $this->faker->email,
        ]);

        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('password', $result['data']);
    }

    /**
     * Test columns that aren't marked as fillable can't be populated.
     */
    public function testOnlyFillable()
    {
        $result = $this->writedown->getService('api')->user()->create([
            'email'        => $this->faker->email,
            'password'     => $this->faker->word,
            'not_fillable' => $this->faker->word,
        ]);

        $this->assertTrue($result['success']);
        $this->assertFalse(property_exists($result['data'], 'not_fillable'));
    }

    /**
     * The user's email must be unique.
     */
    public function testEmailUnique()
    {
        // Create a user
        $user = $this->resources->user();

        // Try to create another user with the same email
        $result = $this->writedown->getService('api')->user()->create([
            'email'    => $user->email,
            'password' => $this->faker->word,
        ]);

        // Check that the errors expected are returned
        $this->assertFalse($result['success']);
    }
}
