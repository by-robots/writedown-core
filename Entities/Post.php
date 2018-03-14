<?php

namespace Tests\Entities;

use Tests\TestCase;

class Post extends TestCase
{
    public function testTimestampsSetOnPersist()
    {
        // Create a new event
        $createdAt = new \DateTime('now');
        $event     = $this->resources->post();

        // Make sure dates have been set correctly
        $this->assertEquals($createdAt->format('Y-m-d H:i:s'), $event->created_at);
        $this->assertEquals($createdAt->format('Y-m-d H:i:s'), $event->updated_at);
    }

    public function testTimestampsOnUpdate()
    {
        // Create a new event
        $event = $this->resources->post();
        usleep(1000000); // Allow one second to pass so the updated timestamp
                         // will be different to created_at.

        // Update it
        $event->title = $this->resources->faker->sentence();
        $this->writedown->database()->flush();

        // Make sure dates have been set and only updated_at has been changed
        $event = $this->writedown->database()->find('WriteDown\Entities\Post', $event->id);
        $this->assertGreaterThan($event->created_at, $event->updated_at);
    }
}
