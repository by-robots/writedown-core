<?php

namespace WriteDown\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use WriteDown\Sessions\AuraSession;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

class HTTPServiceProvider extends AbstractServiceProvider
{
    /**
     * Services provided by the service provider.
     *
     * @var array
     */
    protected $provides = [
        'Psr\Http\Message\ResponseInterface',
        'Psr\Http\Message\RequestInterface',
        'WriteDown\Sessions\SessionInterface',
        'Zend\Diactoros\Response\EmitterInterface'
    ];

    /**
     * Register providers into the container.
     */
    public function register()
    {
        $this->getContainer()
            ->add('Psr\Http\Message\ResponseInterface', Response::class);

        $this->getContainer()->add('Psr\Http\Message\RequestInterface', function() {
            return ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
            );
        });

        $this->getContainer()
            ->add('Zend\Diactoros\Response\EmitterInterface', SapiEmitter::class);

        $this->getContainer()
            ->add('WriteDown\Sessions\SessionInterface', AuraSession::class);
    }
}
