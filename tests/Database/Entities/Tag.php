<?php

namespace Tests\Entities\Database;

use Tests\TestCase;

class Tag extends TestCase
{
    /**
     * created_at and updated_at should both be set before the entity is
     * persisted.
     */
    public function testTimestampsSetOnPersist()
    {
        // Create a new tag
        $tag = $this->resources->tag();

        // Make sure dates have been set correctly
        $this->assertNotNull($tag->created_at);
        $this->assertNotNull($tag->updated_at);
        $this->assertEquals(
            $tag->created_at->format('Y-m-d H:i:s'),
            $tag->updated_at->format('Y-m-d H:i:s')
        );
    }

    /**
     * The updated_at timestamp should be updated when the entity is updated.
     */
    public function testTimestampsOnUpdate()
    {
        // Create a new tag
        $tag = $this->resources->tag();
        usleep(1100000); // Allow one and a bit seconds to pass so the updated
                                         // timestamp will be different to created_at.

        // Update it
        $tag->name = $this->resources->faker->word;
        $this->resources->flush();

        // Make sure dates have been set and only updated_at has been changed
        $this->assertGreaterThan(
            $tag->created_at->format('Y-m-d H:i:s'),
            $tag->updated_at->format('Y-m-d H:i:s')
        );
    }
}
