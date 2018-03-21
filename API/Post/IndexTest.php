<?php

namespace Tests\API\Post;

use Tests\TestCase;

class IndexTest extends TestCase
{
    /**
     * When there are no posts an empty array should be returned and success
     * should be indicated.
     */
    public function testNoPosts()
    {
        // Request posts
        $result = $this->writedown->api()->post()->index();

        // Check that an empty array is returned
        $this->assertEquals(['success' => true, 'data' => []], $result);
    }

    /**
     * When only one post is available it should still be returned in
     * an array.
     */
    public function testRetrievesOne()
    {
        // Create one post
        $post = $this->resources->post();

        // Request the post index
        $result = $this->writedown->api()->post()->index();

        // Check that the result contains one entry
        $this->assertEquals(1, count($result['data']));
        $this->assertEquals($post->id, $result['data'][0]->id); // Double check the ID. I'd be very confused if this failed, but y'know.
    }

    /**
     * When there is more than one post they should be returned in an array.
     */
    public function testRetrievesMany()
    {
        $postCount = 5;
        for ($i = 0; $i < $postCount; $i++) {
            $this->resources->post();
        }

        // Request the post index
        $result = $this->writedown->api()->post()->index();

        // Check that the result contains one entry
        $this->assertEquals($postCount, count($result['data']));
    }

    /**
     * By default posts should be order by their publish_at value in descending
     * order.
     */
    public function testDefaultOrdering()
    {
        // Make three posts
        $first  = $this->resources->post();
        $second = $this->resources->post();
        $third  = $this->resources->post();

        // Modify publish_at values so $third is most recent and $first last.
        $second->publish_at = new \DateTime('-1 week');
        $first->publish_at  = new \DateTime('-2 weeks');
        $this->resources->flush();

        // Retrieve the posts
        $result = $this->writedown->api()->post()->index();

        // Check the order is correct
        $this->assertEquals($third->id, $result['data'][0]->id);
        $this->assertEquals($second->id, $result['data'][1]->id);
        $this->assertEquals($first->id, $result['data'][2]->id);
    }

    /**
     * By default, only posts with publish_at dates in the future should be
     * returned.
     */
    public function testDefaultPublishAtFiltering()
    {
        // Make two posts - one with a NULL publish_at value, one with a value
        // in the future.
        $noPublishAt     = $this->resources->post();
        $publishInFuture = $this->resources->post();

        $noPublishAt->publish_at     = null;
        $publishInFuture->publish_at = new \DateTime('+1 week');
        $this->resources->flush();

        // Grab the index
        $result = $this->writedown->api()->post()->index();

        // It should be empty
        $this->assertEquals(0, count($result['data']));
    }
}
