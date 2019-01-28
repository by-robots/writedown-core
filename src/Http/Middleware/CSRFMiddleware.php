<?php

namespace ByRobots\WriteDown\HTTP\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ByRobots\WriteDown\CSRF\CSRFInterface;

class CSRFMiddleware
{
    /**
     * @var \ByRobots\WriteDown\CSRF\CSRFInterface
     */
    private $csrf;

    /**
     * Get our act together.
     *
     * @param \ByRobots\WriteDown\CSRF\CSRFInterface $csrf
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
     * TODO: Return an appropriate HTTP status code.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     * @param callable                                 $next
     *
     * @return mixed
     * @throws \Exception
     */
    public function validate(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ) {
        switch ($request->getMethod()) {
            case 'POST':
                $body = $request->getParsedBody();
                break;
            case 'GET':
                $body = $request->getQueryParams();
                break;
            default:
                throw new \Exception('Invalid Request.');
        }

        if (!$this->csrf->isValid($body['csrf'])) {
            throw new \Exception('Invalid CSRF.');
        }

        return $next($request, $response);
    }
}
