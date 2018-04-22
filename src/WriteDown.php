<?php

namespace ByRobots\WriteDown;

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
     * @var \League\Container\ContainerInterface
     */
    private $container;

    /**
     * The app's router.
     *
     * @var \League\Route\RouteCollectionInterface
     */
    private $router;

    /**
     * ByRobots\WriteDown's core services.
     *
     * @var array
     */
    private $services = [
        APIServiceProvider::class,
        HTTPServiceProvider::class,
        MiscServiceProvider::class,
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
     * Get the API.
     *
     * @return \ByRobots\WriteDown\API\Interfaces\APIInterface
     */
    public function api()
    {
        return $this->getContainer()
            ->get('ByRobots\WriteDown\API\Interfaces\APIInterface');
    }

    /**
     * Get the Markdown converter.
     *
     * @return \ByRobots\WriteDown\Markdown\MarkdownInterface
     */
    public function markdown()
    {
        return $this->getContainer()
            ->get('ByRobots\WriteDown\Markdown\MarkdownInterface');
    }

    /**
     * Get the session manager.
     *
     * @return \ByRobots\WriteDown\Sessions\SessionInterface
     */
    public function session()
    {
        return $this->getContainer()
            ->get('ByRobots\WriteDown\Sessions\SessionInterface');
    }

    /**
     * Get the CSRF manager.
     *
     * @return \ByRobots\WriteDown\CSRF\CSRFInterface
     */
    public function csrf()
    {
        return $this->getContainer()
            ->get('ByRobots\WriteDown\CSRF\CSRFInterface');
    }

    /**
     * Get the authentication manager.
     *
     * @return \ByRobots\WriteDown\Auth\Interfaces\AuthInterface
     */
    public function auth()
    {
        return $this->getContainer()
            ->get('ByRobots\WriteDown\Auth\Interfaces\AuthInterface');
    }

    /**
     * Run ByRobots\WriteDown!
     *
     * @return void
     */
    public function init()
    {
        $response = $this->getRouter()
            ->dispatch($this->request(), $this->response());

        $this->emitter()->emit($response);
    }
}
