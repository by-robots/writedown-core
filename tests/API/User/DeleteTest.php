<?php

namespace Tests\API\User;

use Tests\TestCase;

class DeleteTest extends TestCase
{
    /**
     * A user can be deleted.
     */
    public function testDeleted()
    {
        // Make a user, then request it's deletion
        $user   = $this->resources->user();
        $result = $this->writedown->api()->user()->delete($user->id);

        // Test that the response is correct and the user is no longer in the database
        $databaseResult = $this->writedown->database()->getRepository('WriteDown\Database\Entities\User')
            ->findOneBy(['id' => $user->id]);

        $this->assertTrue($result['success']);
        $this->assertNull($databaseResult);
    }

    /**
     * A user that does not exist can not be deleted.
     */
    public function testMissing()
    {
        $result = $this->writedown->api()->user()->delete(mt_rand(1000, 9999));

        $this->assertFalse($result['success']);
        $this->assertEquals(['Not found.'], $result['data']);
    }
}
