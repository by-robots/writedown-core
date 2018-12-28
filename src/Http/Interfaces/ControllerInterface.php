<?php

namespace ByRobots\WriteDown\Http\Interfaces;

use ByRobots\WriteDown\WriteDown;
use Psr\Http\Message\ServerRequestInterface;

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
     * Sets the WriteDown object, allowing it's object to be accessible to
     * routes.
     *
     * @param \ByRobots\WriteDown\WriteDown $writedown
     */
    public function setWritedown(WriteDown $writedown);
}
