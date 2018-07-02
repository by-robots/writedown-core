<?php

namespace Tests\API\User;

use Tests\TestCase;

class IndexTest extends TestCase
{
    /**
     * When there are no users an empty array should be returned and success
     * should be indicated.
     */
    public function testNoUsers()
    {
        // Request users
        $result = $this->writedown->api()->user()->index();

        // Check that an empty array is returned
        $this->assertEquals(
            ['success' => true, 'data' => [], 'meta' => []],
            $result
        );
    }

    /**
     * When only one user is available it should still be returned in
     * an array.
     */
    public function testRetrievesOne()
    {
        // Create one post
        $user = $this->resources->user();

        // Request the user index
        $result = $this->writedown->api()->user()->index();

        // Check that the result contains one entry
        $this->assertTrue($result['success']);
        $this->assertEquals(1, count($result['data']));
        $this->assertEquals($user->id, $result['data'][0]->id);
    }

    /**
     * When there is more than one user they should be returned in an array.
     */
    public function testRetrievesMany()
    {
        $userCount = 5;
        for ($i = 0; $i < $userCount; $i++) {
            $this->resources->user();
        }

        // Request the post index
        $result = $this->writedown->api()->user()->index();

        // Check that the result contains one entry
        $this->assertTrue($result['success']);
        $this->assertEquals($userCount, count($result['data']));
    }
}
