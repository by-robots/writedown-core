<?php

namespace Tests\API\Post;

use Tests\TestCase;

class IndexTest extends TestCase
{
    public function testNoPosts()
    {
        // Request posts
        $result = $this->writedown->api()->post()->index();

        // Check that an empty array is returned
        $this->assertEquals([], $result);
    }
}
