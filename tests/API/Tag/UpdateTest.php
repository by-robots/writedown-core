<?php

namespace Tests\API\Tag;

use Tests\TestCase;

class UpdateTest extends TestCase
{
    /**
     * Changing the tag name when it's valid should work.
     */
    public function testValidUpdate()
    {
        $tag = $this->resources->tag();

        do {
            $newName = $this->faker->word;
        } while ($newName == $tag->name);

        $result = $this->writedown->api()->tag()->update($tag->id, ['name' => $newName]);

        // Re-retrieve the tag from the database
        $tag = $this->writedown->database()
            ->getRepository('ByRobots\WriteDown\Database\Entities\Tag')
            ->findOneBy(['id' => $tag->id]);

        $this->assertTrue($result['success']);
        $this->assertEquals($newName, $tag->name);
    }

    /**
     * When the tag name hasn't changed, but an update request is made,
     * success should be returned.
     */
    public function testUpdateWithSameSlug()
    {
        //
    }

    /**
     * When the slug's updated name matches another tag's the request
     * should fail.
     */
    public function testUpdateInvalid()
    {
        //
    }
}
