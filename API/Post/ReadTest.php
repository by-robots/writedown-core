<?php

namespace Tests\API\Post;

use Tests\TestCase;

class ReadTest extends TestCase
{
    public function testRetrievesPost()
    {
        // Make the post
        $post = $this->resources->post();

        // Attempt to retrieve it
        $result = $this->writedown->api()->post()->read($post->id);

        // Check it
        $this->assertEquals($post->id, $result->id);
    }
}
