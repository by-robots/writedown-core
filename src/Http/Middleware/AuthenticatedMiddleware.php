<?php

namespace ByRobots\WriteDown\HTTP\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ByRobots\WriteDown\Auth\Interfaces\AuthInterface;
use ByRobots\WriteDown\Sessions\SessionInterface;

class AuthenticatedMiddleware
{
    /**
     * @var \ByRobots\WriteDown\Auth\Interfaces\AuthInterface
     */
    private $auth;

    /**
     * @var \ByRobots\WriteDown\Sessions\SessionInterface
     */
    private $sessions;

    /**
     * @param \ByRobots\WriteDown\Auth\Interfaces\AuthInterface $auth
     * @param \ByRobots\WriteDown\Sessions\SessionInterface     $sessions
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
