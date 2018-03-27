<?php

namespace Tests\Entities;

use Tests\TestCase;

class User extends TestCase
{
    /**
     * created_at and updated_at should both be set before the entity is
     * persisted.
     */
    public function testTimestampsSetOnPersist()
    {
        // Create a new user
        $user = $this->resources->user();

        // Make sure dates have been set correctly
        $this->assertNotNull($user->created_at);
        $this->assertNotNull($user->updated_at);
        $this->assertEquals(
            $user->created_at->format('Y-m-d H:i:s'),
            $user->updated_at->format('Y-m-d H:i:s')
        );
    }

    /**
     * The updated_at timestamp should be updated when the entity is updated.
     */
    public function testTimestampsOnUpdate()
    {
        // Create a new post
        $user = $this->resources->user();
        usleep(1100000); // Allow one and a bit seconds to pass so the updated
                                         // timestamp will be different to created_at.

        // Update it
        $user->password = password_hash($this->faker->word, PASSWORD_DEFAULT);
        $this->resources->flush();

        // Make sure dates have been set and only updated_at has been changed
        $this->assertGreaterThan(
            $user->created_at->format('Y-m-d H:i:s'),
            $user->updated_at->format('Y-m-d H:i:s')
        );
    }

    /**
     * The user's token attribute should not be retrievable.
     */
    public function testTokenNotRetrievable()
    {
        $user = $this->resources->user();
        $this->assertNull($user->token);
    }
}
