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
        $result   = $this->writedown->api()->user()->update($user->id, [
            'email' => $newEmail,
        ]);

        // Re-retrieve the user from the database and check the change was saved
        $user = $this->writedown->database()->getRepository('WriteDown\Database\Entities\User')
            ->findOneBy(['id' => $user->id]);

        $this->assertTrue($result['success']);
        $this->assertEquals($newEmail, $user->email);
    }

    /**
     * When a user is not found this should be indicated in the response.
     */
    public function testMissing()
    {
        // Attempt to update a user that doesn't exist
        $result = $this->writedown->api()->user()->update(mt_rand(1000, 9999), [
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
        $result = $this->writedown->api()->user()->update($user->id, [
            'not_fillable' => $this->faker->word,
        ]);

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
        $result = $this->writedown->api()->user()->update($secondUser->id, [
            'email' => $firstUser->email,
        ]);

        // Check that the errors expected are returned
        $this->assertFalse($result['success']);
    }
}
