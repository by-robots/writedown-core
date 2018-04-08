<?php

namespace WriteDown\Http\Interfaces;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use WriteDown\API\Interfaces\APIInterface;
use WriteDown\Auth\Interfaces\AuthInterface;
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
     * Set the API object.
     *
     * @param \WriteDown\API\Interfaces\APIInterface $api
     *
     * @return void
     */
    public function setAPI(APIInterface $api);

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
     * @throws \Exception
     */
    public function setCSRF(CSRFInterface $csrf);

    /**
     * Set the auth verifier.
     *
     * @param \WriteDown\Auth\Interfaces\AuthInterface $auth
     *
     * @return void
     */
    public function setAuth(AuthInterface $auth);
}
