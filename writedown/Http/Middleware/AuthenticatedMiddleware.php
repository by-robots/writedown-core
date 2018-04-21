<?php

namespace WriteDown\HTTP\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use WriteDown\Auth\Interfaces\AuthInterface;
use WriteDown\Sessions\SessionInterface;

class AuthenticatedMiddleware
{
    /**
     * @var \WriteDown\Auth\Interfaces\AuthInterface
     */
    private $auth;

    /**
     * @var \WriteDown\Sessions\SessionInterface
     */
    private $sessions;

    /**
     * @param \WriteDown\Auth\Interfaces\AuthInterface $auth
     * @param \WriteDown\Sessions\SessionInterface     $sessions
     *
     * @return void
     */
    public function __construct(AuthInterface $auth, SessionInterface $sessions)
    {
        $this->auth     = $auth;
        $this->sessions = $sessions;
    }

    /**
     * Validate the user is logged in.
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
            !$this->sessions->get('auth_token') or
            !$this->auth->verifyToken($this->sessions->get('auth_token'))
        ) {
            throw new \Exception('Invalid request.');
        }

        return $next($request, $response);
    }
}
