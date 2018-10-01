<?php

namespace Tests\API\Post;

use Tests\TestCase;

class DetachedPostTest extends TestCase
{
    /**
     * A detached post should not appear in the index by default.
     */
    public function testNotInIndex()
    {
        // Create a detached post
        $this->resources->detachedPost();

        // Request posts
        $result = $this->writedown->api()->post()->index();

        // Check that an empty array is returned
        $this->assertEquals(
            ['success' => true, 'data' => [], 'meta' => []],
            $result
        );
    }
}
