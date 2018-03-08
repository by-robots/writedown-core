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
    public function &getContainer()
    {
        return $this->container;
    }

    /**
     * Return the app's router.
     *
     * @return League\Route\RouteCollection
     */
    public function &getRouter()
    {
        return $this->router;
    }

    /**
     * Run WriteDown!
     *
     * @return void
     */
    public function init()
    {
        $response = $this->getRouter()->dispatch(
            $this->getContainer()->get('request'),
            $this->getContainer()->get('response')
        );

        $this->getContainer()->get('emitter')->emit($response);
    }
}
