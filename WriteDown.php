<?php

namespace WriteDown;

use League\Container\Container;
use League\Route\RouteCollection;

class WriteDown
{
    /**
     * The service container.
     *
     * @var League\Container\Container
     */
    private $container;

    /**
     * The app's router.
     *
     * @var League\Route\RouteCollection
     */
    private $router;

    /**
     * Start the app up.
     *
     * @rerurn void
     */
    public function __construct()
    {
        $this->container = new Container;
        $this->router    = new RouteCollection($this->getContainer());
    }

    /**
     * Return the app's container.
     *
     * @return League\Container\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Return the app's router.
     *
     * @return League\Route\RouteCollection
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * When no WriteDown method is matched check to see if the container has an
     * item of the same name, and return that.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     * @throws BadMethodCallException
     */
    public function __call($item, $args)
    {
        if ($this->getContainer()->has($item)) {
            return $this->getContainer()->get($item);
        }

        throw new \BadMethodCallException("Method $method is not a valid method.");
    }


    /**
     * Run WriteDown!
     *
     * @return void
     */
    public function init()
    {
        $response = $this->getRouter()->dispatch($this->request(), $this->response());
        $this->emitter()->emit($response);
    }
}
