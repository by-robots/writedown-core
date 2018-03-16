<?php

namespace Tests\API\Post;

use Tests\TestCase;

class IndexTest extends TestCase
{
    public function testNoPosts()
    {
        // Request posts
        $result = $this->writedown->api()->post()->index();

        // Check that an empty array is returned
        $this->assertEquals([], $result);
    }

    public function testRetrievesOne()
    {
        // Create one post
        $post = $this->resources->post();

        // Request the post index
        $result = $this->writedown->api()->post()->index();

        // Check that the result contains one entry
        $this->assertEquals(1, count($result));
        $this->assertEquals($post->id, $result[0]->id); // Double check the ID. I'd be very confused if this failed, but y'know.
    }

    public function testRetrievesMany()
    {
        $postCount = 5;
        for ($i = 0; $i < $postCount; $i++) {
            $this->resources->post();
        }

        // Request the post index
        $result = $this->writedown->api()->post()->index();

        // Check that the result contains one entry
        $this->assertEquals($postCount, count($result));
    }

    /**
     * By default posts should be order by their publish_at value in descending
     * order.
     */
    public function testDefaultOrdering()
    {
        // Make two posts
        $secondPost = $this->resources->post();
        $firstPost  = $this->resources->post();

        // Set first post's publish_at value to be in the past
        $thePast               = new \DateTime('-1 week');
        $firstPost->publish_at = $thePast;
        $this->resources->flush();

        // Now grab the index
        $result = $this->writedown->api()->post()->index();

        // And check the order
        $this->assertEquals($firstPost->id, $result[0]->id);
        $this->assertEquals($secondPost->id, $result[1]->id);
    }
}
