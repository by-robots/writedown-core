<?php

namespace WriteDown\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use WriteDown\CSRF\CSRFInterface;
use WriteDown\Sessions\SessionInterface;

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
     * @param \WriteDown\Sessions\SessionInterface $sessions
     *
     * @return void
     */
    public function setSessions(SessionInterface $sessions);

    /**
     * Set the view generation object.
     *
     * @param \Slim\Views\PhpRenderer $view
     *
     * @return void
     */
    public function setView($view);

    /**
     * Set the CSRF manager.
     *
     * @param \WriteDown\CSRF\CSRFInterface $csrf
     *
     * @return void
     */
    public function setCSRF(CSRFInterface $csrf);
}
