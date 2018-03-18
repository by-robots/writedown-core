<?php

namespace WriteDown;

use Interop\Container\ContainerInterface;
use League\Route\RouteCollection;

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
     * Start the app up.
     *
     * @rerurn void
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->router    = new RouteCollection($this->getContainer());
    }

    /**
     * When no WriteDown method is matched check to see if the container has an
     * item of the same name, and return that.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __call($method, $args)
    {
        if ($this->container->has($method)) {
            return $this->getContainer()->get($method);
        }

        throw new \BadMethodCallException("Method $method is not a valid method.");
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
     * Get the Request service.
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function request()
    {
        return $this->getContainer()
            ->get('Psr\Http\Message\RequestInterface');
    }

    /**
     * Get the Response service.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function response()
    {
        return $this->getContainer()
            ->get('Psr\Http\Message\ResponseInterface');
    }

    /**
     * Get the Emitter service.
     *
     * @return \Zend\Diactoros\Response\EmitterInterface
     */
    public function emitter()
    {
        return $this->getContainer()
            ->get('Zend\Diactoros\Response\EmitterInterface');
    }

    /**
     * Get the Entity Manager service.
     *
     * @return \Doctrine\ORM\EntityManagerInterface
     */
    public function database()
    {
        return $this->getContainer()
            ->get('Doctrine\ORM\EntityManagerInterface');
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
