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
        $user = $this->writedown->api()->user()->create([
            'email'    => $this->faker->email,
            'password' => $this->faker->word,
        ]);

        // Check we have something
        $this->assertTrue($user['success']);

        // Now attempt to retrieve it from the database to make sure it's been
        // stored
        $result = $this->writedown->database()
            ->getRepository('WriteDown\Database\Entities\User')
            ->findOneBy(['id' => $user['data']->id]);

        // Check it
        $this->assertEquals($user['data']->id, $result->id);
    }

    /**
     * Tests that a user can't be created without an email.
     */
    public function testValidationNoEmail()
    {
        // Attempt to create a user without an email.
        $result = $this->writedown->api()->user()->create([
            'password' => $this->faker->word,
        ]);

        // Check the error was as expected
        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('email', $result['data']);
    }

    /**
     * Test a user can not be created without a password.
     */
    public function testValidationNoPassword()
    {
        $result = $this->writedown->api()->user()->create([
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
        $result = $this->writedown->api()->user()->create([
            'email'        => $this->faker->email,
            'password'     => $this->faker->word,
            'not_fillable' => $this->faker->word,
        ]);

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
        $result = $this->writedown->api()->user()->create([
            'email'    => $user->email,
            'password' => $this->faker->word,
        ]);

        // Check that the errors expected are returned
        $this->assertFalse($result['success']);
    }
}
