<?php

namespace Tests\API\Tag;

use Tests\TestCase;

class IndexTest extends TestCase
{
    /**
     * When there are no tags an empty array should be returned and success
     * should be indicated.
     */
    public function testNoTags()
    {
        // Request posts
        $result = $this->writedown->api()->tag()->index();

        // Check that an empty array is returned
        $this->assertEquals(
            ['success' => true, 'data' => [], 'meta' => []],
            $result
        );
    }

    /**
     * When only one tag is available it should still be returned in
     * an array.
     */
    public function testRetrievesOne()
    {
        // Create one tag
        $tag = $this->resources->tag();

        // Request the tag index
        $result = $this->writedown->api()->tag()->index();

        // Check that the result contains one entry
        $this->assertEquals(1, count($result['data']));
        $this->assertEquals($tag->id, $result['data'][0]->id);
    }

    /**
     * When there is more than one tag they should be returned in an array.
     */
    public function testRetrievesMany()
    {
        $tagCount = 5;
        for ($i = 0; $i < $tagCount; $i++) {
            $this->resources->tag();
        }

        // Request the post index
        $result = $this->writedown->api()->tag()->index();

        // Check that the result contains the right number of entries
        $this->assertEquals($tagCount, count($result['data']));
    }
}
