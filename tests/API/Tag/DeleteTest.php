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
        //
    }
}
