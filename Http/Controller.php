<?php

namespace WriteDown\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
     * @var \Slim\Views\PhpRenderer
     */
    protected $view;

    /**
     * Set the request object.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return void
     */
    public function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * Set the response object.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return void
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Set the view generation object.
     *
     * @param \Slim\Views\PhpRenderer $view
     *
     * @return void
     */
    public function setView($view)
    {
        $this->view = $view;
    }
}
