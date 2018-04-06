<?php

namespace Tests\API\Post;

use Tests\TestCase;

class PaginationTest extends TestCase
{
    /**
     * The index request for posts should be paginated.
     */
    public function testIsPaginated()
    {
        // Create 20 posts
        for ($i = 0; $i < 20; $i++) {
            $this->resources->post();
        }

        // Request an index, with 10 per index
        $result = $this->writedown->api()->post()->index([
            'pagination' => ['per_page' => 10],
        ]);

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
     * Subsequent pages can be requested.
     */
    public function testPageRequests()
    {
        // Create 15 posts
        for ($i = 0; $i < 15; $i++) {
            $this->resources->post();
        }

        // Request an index, with 10 per index
        $result = $this->writedown->api()->post()->index(['pagination' => [
            'per_page' => 10,
            'page'     => 2,
        ]]);

        $this->assertEquals(5, count($result['data']));
        $this->assertEquals(10, $result['meta']['per_page']);
        $this->assertEquals(2, $result['meta']['current_page']);
        $this->assertEquals(2, $result['meta']['total_pages']);
    }

    /**
     * Pages that don't exist can't be retrieved and an appropriate response
     * should be returned.
     */
    public function testNoPage()
    {
        // Create 20 posts
        for ($i = 0; $i < 20; $i++) {
            $this->resources->post();
        }

        // Request an index, with 10 per index
        $result = $this->writedown->api()->post()->index(['pagination' => [
            'per_page' => 10,
            'page'     => 3,
        ]]);

        // An error should be returned
        $this->assertFalse($result['success']);
        $this->assertEquals(['Not found.'], $result['data']);
    }
}
