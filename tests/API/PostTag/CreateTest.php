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
}
