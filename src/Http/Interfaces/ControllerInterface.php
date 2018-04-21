<?php

namespace ByRobots\WriteDown\Http\Interfaces;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ByRobots\WriteDown\API\Interfaces\APIInterface;
use ByRobots\WriteDown\Auth\Interfaces\AuthInterface;
use ByRobots\WriteDown\CSRF\CSRFInterface;
use ByRobots\WriteDown\Markdown\MarkdownInterface;
use ByRobots\WriteDown\Sessions\SessionInterface;

interface ControllerInterface
{
    /**
     * Set the request object.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return void
     */
    public function setRequest(ServerRequestInterface $request);

    /**
     * Set the response object.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return void
     */
    public function setResponse(ResponseInterface $response);

    /**
     * Set the session management object.
     *
     * @param \ByRobots\WriteDown\Sessions\SessionInterface $sessions
     *
     * @return void
     */
    public function setSessions(SessionInterface $sessions);

    /**
     * Set the API object.
     *
     * @param \ByRobots\WriteDown\API\Interfaces\APIInterface $api
     *
     * @return void
     */
    public function setAPI(APIInterface $api);

    /**
     * Set the CSRF manager.
     *
     * @param \ByRobots\WriteDown\CSRF\CSRFInterface $csrf
     *
     * @return void
     * @throws \Exception
     */
    public function setCSRF(CSRFInterface $csrf);

    /**
     * Set the auth verifier.
     *
     * @param \ByRobots\WriteDown\Auth\Interfaces\AuthInterface $auth
     *
     * @return void
     */
    public function setAuth(AuthInterface $auth);

    /**
     * Set the Markdown parser.
     *
     * @param \ByRobots\WriteDown\Markdown\MarkdownInterface $markdown
     *
     * @return void
     */
    public function setMarkdown(MarkdownInterface $markdown);
}
