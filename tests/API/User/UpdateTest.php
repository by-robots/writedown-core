<?php

namespace Tests\API\User;

use Tests\TestCase;

class UpdateTest extends TestCase
{
    /**
     * When all is well a user should be updated.
     */
    public function testUpdated()
    {
        // Create a user, then update it.
        $user     = $this->resources->user();
        $newEmail = $this->faker->email;
        $result   = $this->writedown->getService('api')->user()->update($user->id, [
            'email' => $newEmail,
        ]);

        $this->assertTrue($result['success']);
        $this->assertEquals($newEmail, $result['data']->email);
    }

    /**
     * When a user is not found this should be indicated in the response.
     */
    public function testMissing()
    {
        // Attempt to update a user that doesn't exist
        $result = $this->writedown->getService('api')->user()->update(mt_rand(1000, 9999), [
            'email' => $this->faker->email,
        ]);

        // Check the result
        $this->assertFalse($result['success']);
        $this->assertEquals(['Not found.'], $result['data']);
    }

    /**
     * Only attributes marked as fillable should be fillable.
     */
    public function testOnlyFillable()
    {
        $user   = $this->resources->user();
        $result = $this->writedown->getService('api')->user()->update($user->id, [
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
        // Create twi users
        $firstUser  = $this->resources->user();
        $secondUser = $this->resources->user();

        // Try to set $secondUser's email to $firstUser's
        $result = $this->writedown->getService('api')->user()->update($secondUser->id, [
            'email' => $firstUser->email,
        ]);

        // Check that the errors expected are returned
        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('email', $result['data']);
    }

    /**
     * Test the email must be valid.
     */
    public function testEmailValid()
    {
        // Create a user, then update it.
        $user     = $this->resources->user();
        $result   = $this->writedown->getService('api')->user()->update($user->id, [
            'email' => $this->faker->word,
        ]);

        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('email', $result['data']);
    }
}
