<?php

namespace ByRobots\WriteDown\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ByRobots\WriteDown\API\Interfaces\APIInterface;
use ByRobots\WriteDown\Auth\Interfaces\AuthInterface;
use ByRobots\WriteDown\CSRF\CSRFInterface;
use ByRobots\WriteDown\Http\Interfaces\ControllerInterface;
use ByRobots\WriteDown\Markdown\MarkdownInterface;
use ByRobots\WriteDown\Sessions\SessionInterface;

/**
 * @codeCoverageIgnore
 */
abstract class Controller implements ControllerInterface
{
    use ControllerHelpers;

    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $request;

    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * @var \ByRobots\WriteDown\Sessions\SessionInterface
     */
    protected $session;

    /**
     * @var \ByRobots\WriteDown\API\Interfaces\APIInterface
     */
    protected $api;

    /**
     * @var \ByRobots\WriteDown\CSRF\CSRFInterface
     */
    protected $csrf;

    /**
     * @var \ByRobots\WriteDown\Auth\Interfaces\AuthInterface
     */
    protected $auth;

    /**
     * @var \ByRobots\WriteDown\Markdown\MarkdownInterface
     */
    protected $markdown;

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
    public function setSession(SessionInterface $session)
    {
        $this->session = $session;
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

    /**
     * @inheritDoc
     */
    public function setMarkdown(MarkdownInterface $markdown)
    {
        $this->markdown = $markdown;
    }
}
