<?php

namespace Tests\API\User;

use Tests\TestCase;

class PaginationTest extends TestCase
{
    /**
     * The index request for users should be paginated.
     */
    public function testIsPaginated()
    {
        // Create 20 posts
        for ($i = 0; $i < 20; $i++) {
            $this->resources->user();
        }

        // Request an index, with 10 per index
        $result = $this->writedown->api()->user()->index(['pagination' => [
            'per_page'     => 10,
            'current_page' => 1,
        ]]);

        // We should have received 10 posts
        $this->assertEquals(10, count($result['data']));

        // And meta data should be available telling us more information
        $this->assertArrayHasKey('meta', $result);

        $meta = $result['meta'];
        $this->assertEquals(10, $meta['per_page']);
        $this->assertEquals(1, $meta['current_page']);
        $this->assertEquals(2, $meta['total_pages']);
    }

    /**
     * Subsequent users can be requested.
     */
    public function testPageRequests()
    {
        // Create 15 posts
        for ($i = 0; $i < 15; $i++) {
            $this->resources->user();
        }

        // Request an index, with 10 per index
        $result = $this->writedown->api()->user()->index(['pagination' => [
            'per_page'     => 10,
            'current_page' => 2,
        ]]);

        $this->assertEquals(5, count($result['data']));
        $this->assertEquals(10, $result['meta']['per_page']);
        $this->assertEquals(2, $result['meta']['current_page']);
        $this->assertEquals(2, $result['meta']['total_pages']);
    }
}
