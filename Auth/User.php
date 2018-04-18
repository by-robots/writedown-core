<?php

namespace Tests\Auth;

use Tests\TestCase;

class User extends TestCase
{
    /**
     * The user should be returned.
     */
    public function testRetrievesUser()
    {
        $token = bin2hex(random_bytes(64));
        $user  = $this->writedown->api()->user()->create([
            'email'    => $this->faker->email,
            'password' => $this->faker->word,
            'token'    => $token,
        ]);

        // Attempt to login with the correct details and check that it passes
        $this->assertEquals($user['data']->id, $this->writedown->auth()->user($token)->id);
    }
}
