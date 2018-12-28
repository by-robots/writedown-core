<?php

namespace Tests\API\Post;

use Tests\TestCase;

class DeleteTest extends TestCase
{
    /**
     * A post can be deleted.
     */
    public function testDeleted()
    {
        // Make a post, then request it's deletion
        $post   = $this->resources->post();
        $result = $this->writedown->getService('api')->post()->delete($post->id);

        // Query the database and try to retrieve the post
        $databaseResult = $this->writedown->getService('entityManager')
            ->getRepository('ByRobots\WriteDown\Database\Entities\Post')
            ->findOneBy(['id' => $post->id]);

        // Check the results
        $this->assertTrue($result['success']);
        $this->assertNull($databaseResult);
    }

    /**
     * A post that does not exist can not be deleted.
     */
    public function testMissing()
    {
        $result = $this->writedown->getService('api')->post()->delete(mt_rand(1000, 9999));

        $this->assertFalse($result['success']);
        $this->assertEquals(['Not found.'], $result['data']);
    }

    /**
     * When deleting a post any post_tag relationships should also be removed.
     */
    public function testDeletesPostTagRelationship()
    {
        // Create the post and tag
        $post = $this->resources->post();
        $tag  = $this->resources->tag();

        // Add the tag to the post
        $result = $this->writedown->getService('api')->postTag()->create([
            'post_id' => $post->id,
            'tag_id'  => $tag->id,
        ]);

        // Now delete the post
        $this->writedown->getService('api')->post()->delete($post->id);

        // Check the relationship no longer exists
        $databaseResult = $this->writedown->getService('entityManager')
            ->getRepository('ByRobots\WriteDown\Database\Entities\PostTag')
            ->findOneBy(['post_id' => $post->id, 'tag_id' => $tag->id]);

        $this->assertNull($databaseResult);
    }
}
