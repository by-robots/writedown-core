<?php

namespace WriteDown\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use WriteDown\API\Interfaces\APIInterface;
use WriteDown\Auth\Interfaces\AuthInterface;
use WriteDown\CSRF\CSRFInterface;
use WriteDown\Http\Interfaces\ControllerInterface;
use WriteDown\Sessions\SessionInterface;

/**
 * @codeCoverageIgnore
 */
abstract class Controller implements ControllerInterface
{
    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $request;

    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * @var \WriteDown\Sessions\SessionInterface
     */
    protected $sessions;

    /**
     * @var \WriteDown\API\Interfaces\APIInterface
     */
    protected $api;

    /**
     * @var \Slim\Views\PhpRenderer
     */
    protected $view;

    /**
     * @var \WriteDown\CSRF\CSRFInterface
     */
    protected $csrf;

    /**
     * @var \WriteDown\Auth\Interfaces\AuthInterface
     */
    protected $auth;

    /**
     * @inheritDoc
     */
    public function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @inheritDoc
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @inheritDoc
     */
    public function setSessions(SessionInterface $sessions)
    {
        $this->sessions = $sessions;
    }

    /**
     * @inheritDoc
     */
    public function setAPI(APIInterface $api)
    {
        $this->api = $api;
    }

    /**
     * @inheritDoc
     */
    public function setView($view)
    {
        $this->view = $view;
    }

    /**
     * @inheritDoc
     */
    public function setCSRF(CSRFInterface $csrf)
    {
        $this->csrf = $csrf;

        if (is_null($this->csrf->get())) {
            $this->csrf->generate();
        }
    }

    /**
     * @inheritDoc
     */
    public function setAuth(AuthInterface $auth)
    {
        $this->auth = $auth;
    }
}
