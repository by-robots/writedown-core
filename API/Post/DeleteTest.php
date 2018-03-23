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
        $result = $this->writedown->api()->post()->delete($post->id);

        // Test that the response is correct and the post is no longer in the database
        $databaseResult = $this->writedown->database()->getRepository('WriteDown\Entities\Post')
            ->findOneBy(['id' => $post->id]);

        $this->assertTrue($result['success']);
        $this->assertNull($databaseResult);
    }

    /**
     * A post that does not exist can not be deleted.
     */
    public function testMissing()
    {
        $result = $this->writedown->api()->post()->delete(mt_rand(1000, 9999));

        $this->assertFalse($result['success']);
        $this->assertEquals(['Not found.'], $result['data']);
    }
}
