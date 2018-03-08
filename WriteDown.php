<?php

namespace WriteDown;

use League\Container\Container;

class WriteDown
{
    /**
     * The service container.
     *
     * @var League\Container\Container
     */
    private $container;

    /**
     * Start the app up.
     *
     * @rerurn void
     */
    public function __construct()
    {
        $this->container = new Container;
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
     * Run WriteDown!
     *
     * @return void
     */
    public function init()
    {
        $response = $this->getContainer()->get('router')->dispatch(
            $this->getContainer()->get('request'),
            $this->getContainer()->get('response')
        );

        $this->getContainer()->get('emitter')->emit($response);
    }
}
