<?php

namespace Tests\API\PostTag;

use Tests\TestCase;

class CreateTest extends TestCase
{
    /**
     * It should be possible for an existing tag to be assigned to an existing
     * post.
     */
    public function testAssignsTag()
    {
        // Create the post and tag
        $post = $this->resources->post();
        $tag  = $this->resources->tag();

        // Attempt to tag $post with $tag
        $result = $this->writedown->api()->postTag()->create([
            'post_id' => $post->id,
            'tag_id'  => $tag->id,
        ]);

        // Check it worked
        $this->assertTrue($result['success']);
    }

    /**
     * The post must exist.
     */
    public function testPostMustExist()
    {
        // Create the tag
        $tag = $this->resources->tag();

        // Attempt to tag $post with $tag
        $result = $this->writedown->api()->postTag()->create([
            'post_id' => mt_rand(1000, 9999),
            'tag_id'  => $tag->id,
        ]);

        // Check it worked
        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('post_id', $result['data']);
    }

    /**
     * The tag must exist.
     */
    public function testTagMustExist()
    {
        // Create the tag
        $post = $this->resources->post();

        // Attempt to tag $post with $tag
        $result = $this->writedown->api()->postTag()->create([
            'post_id' => $post->id,
            'tag_id'  => mt_rand(1000, 9999),
        ]);

        // Check it worked
        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('tag_id', $result['data']);
    }
}
