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

        $this->assertTrue($result['success']);
        $this->assertEquals($newName, $result->name);
    }

    /**
     * When the tag name hasn't changed, but an update request is made,
     * success should be returned.
     */
    public function testUpdateWithSameSlug()
    {
        $tag    = $this->resources->tag();
        $result = $this->writedown->api()->tag()->update($tag->id, ['name' => $tag->name]);
        $this->assertTrue($result['success']);
    }

    /**
     * When the slug's updated name matches another tag's the request
     * should fail.
     */
    public function testUpdateInvalid()
    {
        $tag    = $this->resources->tag();
        $result = $this->writedown->api()->tag()->update($tag->id, ['name' => 'I am not a valid name!!!']);
        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('name', $result['data']);
    }
}
