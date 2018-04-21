<?php

namespace Tests\Http\Middleware\CSRF;

use Tests\Stubs\SessionStub;
use Tests\TestCase;
use WriteDown\Auth\Token;
use WriteDown\CSRF\Hash;
use WriteDown\HTTP\Middleware\CSRFMiddleware;

class ValidatesToken extends TestCase
{
    /**
     * @var \WriteDown\CSRF\CSRFInterface
     */
    private $csrf;

    /**
     * @var \WriteDown\HTTP\Middleware\CSRFMiddleware
     */
    private $provider;

    public function setUp()
    {
        parent::setUp();
        $this->csrf     = new Hash(new SessionStub, new Token);
        $this->provider = new CSRFMiddleware($this->csrf);
    }

    /**
     * When an invalid token is received a request should be thrown.
     */
    public function testInvalidToken()
    {
        // Set-up mocks
        $request = \Mockery::mock('\Psr\Http\Message\ServerRequestInterface')->makePartial();
        $request->shouldReceive('getParsedBody')
            ->andReturn([
                'csrf' => 'TXkgc3RvcnkgaXMgYSBsb3QgbGlrZSB5b3Vycywgb25seSBtb3JlIGludGVyZXN0aW5nIOKAmGNhdXNlIGl0IGludm9sdmVzIHJvYm90cy4=',
            ]);

        $response = \Mockery::mock('\Psr\Http\Message\ResponseInterface')->makePartial();

        // Check results
        $this->expectException(\Exception::class);
        $this->provider->validate($request, $response, function () {});
    }

    /**
     * Valid CSRF tokens should pass.
     */
    public function testValidToken()
    {
        // Generate the token
        $this->csrf->generate();
        $token = $this->csrf->get();

        // Set-up mocks
        $request = \Mockery::mock('\Psr\Http\Message\ServerRequestInterface')->makePartial();
        $request->shouldReceive('getParsedBody')
            ->andReturn(['csrf' => $token]);

        $response = \Mockery::mock('\Psr\Http\Message\ResponseInterface')->makePartial();

        // CHeck results
        $result = $this->provider->validate($request, $response, function () {
            return true;
        });

        $this->assertTrue($result);
    }
}
