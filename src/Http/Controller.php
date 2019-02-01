<?php

namespace ByRobots\WriteDown\Http\Controllers;

use ByRobots\WriteDown\WriteDown;
use Psr\Http\Message\ServerRequestInterface;

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
     * @var \ByRobots\WriteDown\WriteDown
     */
    protected $writedown;

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
    public function setWriteDown(WriteDown $writedown)
    {
        $this->writedown = $writedown;
    }
}
