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
     * Set-up WriteDown.
     *
     * @param League\Container\Container $container
     *
     * @return Void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get WriteDown's services.
     *
     * @return League\Container\Container
     */
    public function container()
    {
        return $this->container;
    }
}
