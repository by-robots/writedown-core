<?php

namespace Tests\Entities;

use Tests\TestCase;

class Post extends TestCase
{
    public function testTimestampsSetOnPersist()
    {
        // Create a new event
        $event = $this->resources->post();

        // Make sure dates have been set
        $this->assertNotNull($event->created_at);
        $this->assertNotNull($event->updated_at);
    }
}
