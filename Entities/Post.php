<?php

namespace Tests\Entities;

use Tests\TestCase;
use WriteDown\Entities\Post as Entity;

class Post extends TestCase
{
    public function testTimestampsSetOnPersist()
    {
        // Create a new post
        $post = $this->resources->post();

        // Make sure dates have been set correctly
        $this->assertNotNull($post->created_at);
        $this->assertNotNull($post->updated_at);
        $this->assertEquals(
            $post->created_at->format('Y-m-d H:i:s'),
            $post->updated_at->format('Y-m-d H:i:s')
        );
    }

    public function testTimestampsOnUpdate()
    {
        // Create a new post
        $post = $this->resources->post();
        usleep(1100000); // Allow one and a bit seconds to pass so the updated
                         // timestamp will be different to created_at.

        // Update it
        $post->title = $this->resources->faker->sentence();
        $this->resources->flush();

        // Make sure dates have been set and only updated_at has been changed
        $this->assertGreaterThan(
            $post->created_at->format('Y-m-d H:i:s'),
            $post->updated_at->format('Y-m-d H:i:s')
        );
    }

    public function testSlugGenerated()
    {
        $post        = new Entity;
        $post->title = $this->faker->sentence;
        $post->body  = $this->faker->paragraph;
        $this->writedown->database()->persist($post);

        $this->assertNotNull($post->slug);
    }

    public function testSlugNotOverwritten()
    {
        $post        = new Entity;
        $expected    = $this->faker->slug;
        $post->title = $this->faker->sentence;
        $post->slug  = $expected;
        $post->body  = $this->faker->paragraph;
        $this->writedown->database()->persist($post);

        $this->assertEquals($expected, $post->slug);
    }
}
