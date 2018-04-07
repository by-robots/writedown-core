<?php

namespace WriteDown\HTTP\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use WriteDown\CSRF\CSRFInterface;

class CSRFMiddleware
{
    /**
     * @var \WriteDown\CSRF\CSRFInterface
     */
    private $csrf;

    /**
     * Get our act together.
     *
     * @param \WriteDown\CSRF\CSRFInterface $csrf
     *
     * @return void
     */
    public function __construct(CSRFInterface $csrf)
    {
        $this->csrf = $csrf;
    }

    /**
     * Validate the CSRF token of the request.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param callable                                 $next
     *
     * @return mixed
     * @throws \Exception
     */
    public function validate(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if (
            !array_key_exists('csrf', $request->getParsedBody()) or
            !$this->csrf->isValid($request->getParsedBody()['csrf'])
        ) {
            throw new \Exception('Invalid CSRF.');
        }

        return $next($request, $response);
    }
}
