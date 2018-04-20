<?php

namespace Tests\API\Post;

use Tests\TestCase;

class BySlugTest extends TestCase
{
    /**
     * When a post exists it should be retrieved and provided as an object.
     */
    public function testRetrievesPost()
    {
        // Make the post
        $post = $this->resources->post();

        // Attempt to retrieve it
        $result = $this->writedown->api()->post()->bySlug($post->slug);

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
        $result = $this->writedown->api()->post()->bySlug('SGV5IGJhYnksIHdhbm5hIGtpbGwgYWxsIGh1bWFucz8=');

        // An error should be returned
        $this->assertEquals(['Not found.'], $result['data']);
    }
}
