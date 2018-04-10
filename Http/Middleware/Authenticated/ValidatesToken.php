<?php

namespace Tests\Http\Middleware\Authenticated;

use Tests\Stubs\SessionStub;
use Tests\TestCase;
use WriteDown\HTTP\Middleware\AuthenticatedMiddleware;

class ValidatesToken extends TestCase
{
    /**
     * When an invalid token is presented an exception should be thrown.
     */
    public function testInvalidToken()
    {
        // Add a fake auth key
        $session = new SessionStub;
        $session->set('auth_token', 'WU9VJ1JFIE5PVCBNWSBTVVBFUlZJU09SIQ==');

        // Add that to the provider
        $provider = new AuthenticatedMiddleware($this->writedown->auth(), $session);

        // Make mocks
        $request  = \Mockery::mock('\Psr\Http\Message\ServerRequestInterface')->makePartial();
        $response = \Mockery::mock('\Psr\Http\Message\ResponseInterface')->makePartial();

        // Check it
        $this->expectException(\Exception::class);
        $provider->validate($request, $response, function () {});
    }

    /**
     * A valid token should let the user past.
     */
    public function testValidToken()
    {
        // Create the user with a token we know
        $token = bin2hex(random_bytes(64));
        $this->writedown->api()->user()->create([
            'email'    => $this->faker->email,
            'password' => password_hash($this->faker->word, PASSWORD_DEFAULT),
            'token'    => $token,
        ]);

        // Add the token to the session
        $session = new SessionStub;
        $session->set('auth_token', $token);

        // Create the middleware
        $provider = new AuthenticatedMiddleware($this->writedown->auth(), $session);

        // Make mocks
        $request  = \Mockery::mock('\Psr\Http\Message\ServerRequestInterface')->makePartial();
        $response = \Mockery::mock('\Psr\Http\Message\ResponseInterface')->makePartial();

        // Check it works
        $result = $provider->validate($request, $response, function () {
            return true;
        });

        $this->assertTrue($result);
    }
}
