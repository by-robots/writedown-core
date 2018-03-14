<?php

namespace Tests\Entities;

use Tests\TestCase;

class Post extends TestCase
{
    public function testTimestampsSetOnPersist()
    {
        // Create a new post
        $createdAt = new \DateTime('now');
        $post      = $this->resources->post();

        // Make sure dates have been set correctly
        $this->assertEquals($createdAt->format('Y-m-d H:i:s'), $post->created_at->format('Y-m-d H:i:s'));
        $this->assertEquals($createdAt->format('Y-m-d H:i:s'), $post->updated_at->format('Y-m-d H:i:s'));
    }

    public function testTimestampsOnUpdate()
    {
        // Create a new post
        $post = $this->resources->post();
        usleep(1000000); // Allow one second to pass so the updated timestamp
                         // will be different to created_at.

        // Update it
        $post->title = $this->resources->faker->sentence();
        $this->resources->flush();

        // Make sure dates have been set and only updated_at has been changed
        $this->assertGreaterThan(
            $post->created_at->format('Y-m-d H:i:s'),
            $post->updated_at->format('Y-m-d H:i:s')
        );
    }
}
