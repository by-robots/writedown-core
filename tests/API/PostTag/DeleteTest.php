<?php

namespace Tests\API\PostTag;

use Tests\TestCase;

class DeleteTest extends TestCase
{
    /**
     * Deletes a relationship that exists.
     */
    public function testDeletes()
    {
        // Create everything and link a post to a tag
        $post = $this->resources->post();
        $tag  = $this->resources->tag();
        $this->writedown->api()->postTag()->create([
            'post_id' => $post->id,
            'tag_id'  => $tag->id,
        ]);

        // Delete it
        $result = $this->writedown->api()->postTag()->delete($post->id, $tag->id);

        // Try and retrieve from the database so we can be sure
        $databaseResult = $this->writedown->database()
            ->getRepository('ByRobots\WriteDown\Database\Entities\PostTag')
            ->findOneBy([
                'post_id' => $post->id,
                'tag_id'  => $tag->id,
            ]);

        // Check it
        $this->assertTrue($result['success']);
        $this->assertNull($databaseResult);
    }

    /**
     * Errors when deleting a relationship that doesn't exist.
     */
    public function testMissingRelationship()
    {
        // Delete a relationship that doesn't exist
        $result = $this->writedown->api()->postTag()->delete(mt_rand(1000, 9999), mt_rand(1000, 9999));

        // API says no
        $this->assertFalse($result['success']);
        $this->assertEquals(['Not found.'], $result['data']);
    }
}
