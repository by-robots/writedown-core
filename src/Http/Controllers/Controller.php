<?php

namespace ByRobots\WriteDown\Http\Controllers;

use ByRobots\WriteDown\Http\Interfaces\ControllerInterface;
use ByRobots\WriteDown\WriteDown;
use Psr\Http\Message\ServerRequestInterface;

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
    public function setWritedown(WriteDown $writedown)
    {
        $this->writedown = $writedown;
    }
}
