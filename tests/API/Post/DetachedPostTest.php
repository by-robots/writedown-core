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
        $result = $this->writedown->getService('api')->post()->index();

        // Check that an empty array is returned
        $this->assertEquals(
            ['success' => true, 'data' => [], 'meta' => []],
            $result
        );
    }

    /**
     * A detached post should still be retrievable with extra specification.
     */
    public function testCanStillBeRetrieved()
    {
        // Create a detached post
        $this->resources->detachedPost();

        // Request posts
        $result = $this->writedown->getService('api')->post()->index(['where' => [
            'e.detached = :detached' => ['detached' => true],
        ]]);

        // Check that an empty array is returned
        $this->assertTrue($result['success']);
        $this->assertEquals(1, count($result['data']));
    }

    /**
     * Detached and attached posts should be retrievable at the same time.
     */
    public function testBothRetrieved()
    {
        // Create a detached post
        $this->resources->post();
        $this->resources->detachedPost();

        // Request posts
        $result = $this->writedown->getService('api')->post()->index(['where' => [
            'e.detached = :detached OR e.detached = :attached' => [
                'attached' => false,
                'detached' => true,
            ],
        ]]);

        // Check that an empty array is returned
        $this->assertTrue($result['success']);
        $this->assertEquals(2, count($result['data']));
    }
}
