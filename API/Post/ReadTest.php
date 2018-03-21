<?php

namespace Tests\API\Post;

use Tests\TestCase;

class ReadTest extends TestCase
{
    /**
     * When a post exists it should be retrieved and provided as an object.
     */
    public function testRetrievesPost()
    {
        // Make the post
        $post = $this->resources->post();

        // Attempt to retrieve it
        $result = $this->writedown->api()->post()->read($post->id);

        // Check it
        $this->assertEquals($post->id, $result['data']->id);
    }

    /**
     * When the post doesn't exist it should be indicated as not successful in
     * the response.
     */
    public function testPostNotFound()
    {
        // Attempt to retrieve a non-existent post
        $result = $this->writedown->api()->post()->read(mt_rand(1000, 9999));

        // It should be null
        $this->assertEquals(['Not found.'], $result['data']);
    }
}
