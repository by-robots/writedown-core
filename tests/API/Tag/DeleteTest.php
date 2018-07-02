<?php

namespace Tests\API\Tag;

use Tests\TestCase;

class DeleteTest extends TestCase
{
    /**
     * A tag can be deleted.
     */
    public function testDeleted()
    {
        // Make a tag, then request it's deletion
        $tag    = $this->resources->tag();
        $result = $this->writedown->api()->tag()->delete($tag->id);

        // Attempt to grab the tag from the database
        $databaseResult = $this->writedown->database()
            ->getRepository('ByRobots\WriteDown\Database\Entities\Tag')
            ->findOneBy(['id' => $tag->id]);

        $this->assertTrue($result['success']);
        $this->assertNull($databaseResult);
    }

    /**
     * A tag that does not exist can not be deleted.
     */
    public function testMissing()
    {
        $result = $this->writedown->api()->tag()->delete(mt_rand(1000, 9999));

        $this->assertFalse($result['success']);
        $this->assertEquals(['Not found.'], $result['data']);
    }

    /**
     * When a tag is deleted any corresponding post_tag relationship should also
     * be removed.
     */
    public function testDeletesPostTagRelationship()
    {
        // Create the post and tag
        $post = $this->resources->post();
        $tag  = $this->resources->tag();

        // Add the tag to the post
        $result = $this->writedown->api()->postTag()->create([
            'post_id' => $post->id,
            'tag_id'  => $tag->id,
        ]);

        // Now delete the tag
        $this->writedown->api()->tag()->delete($tag->id);

        // Check the relationship no longer exists
        $databaseResult = $this->writedown->database()
            ->getRepository('ByRobots\WriteDown\Database\Entities\PostTag')
            ->findOneBy(['post_id' => $post->id, 'tag_id' => $tag->id]);

        $this->assertNull($databaseResult);
    }
}
