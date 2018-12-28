<?php

namespace ByRobots\WriteDown;

use ByRobots\WriteDown\Providers\ValidationServiceProvider;
use Interop\Container\ContainerInterface;
use League\Route\RouteCollection;
use ByRobots\WriteDown\Providers\APIServiceProvider;
use ByRobots\WriteDown\Providers\HTTPServiceProvider;
use ByRobots\WriteDown\Providers\MiscServiceProvider;

class WriteDown
{
    /**
     * The service container.
     *
     * @var \Interop\Container\ContainerInterface
     */
    private $container;

    /**
     * The app's router.
     *
     * @var \League\Route\RouteCollectionInterface
     */
    private $router;

    /**
     * WriteDown's core services.
     *
     * @var array
     */
    private $services = [
        APIServiceProvider::class,
        HTTPServiceProvider::class,
        MiscServiceProvider::class,
        ValidationServiceProvider::class,
    ];

    /**
     * Start the app up.
     *
     * @param \Interop\Container\ContainerInterface $container
     *
     * @return void
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->router    = new RouteCollection($this->getContainer());
        $this->loadServices();
    }

    /**
     * Load WriteDown's services.
     *
     * @return void
     */
    private function loadServices()
    {
        foreach ($this->services as $service) {
            $this->getContainer()->addServiceProvider($service);
        }
    }

    /**
     * Return the app's container.
     *
     * @return \Interop\Container\ContainerInterface
     */
    public function &getContainer()
    {
        return $this->container;
    }

    /**
     * Return the app's router.
     *
     * @return \League\Route\RouteCollectionInterface
     */
    public function &getRouter()
    {
        return $this->router;
    }

    /**
     * Get a service.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getService($name)
    {
        return $this->getContainer()->get($name);
    }

    /**
     * Run ByRobots\WriteDown!
     *
     * @return void
     */
    public function init()
    {
        $response = $this->getRouter()
            ->dispatch($this->getService('request'));

        $this->emitter()->emit($response);
    }
}
