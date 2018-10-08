<?php

namespace ByRobots\WriteDown\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use ByRobots\WriteDown\Auth\Token;
use ByRobots\WriteDown\CSRF\Hash;
use ByRobots\WriteDown\Sessions\AuraSession;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

/**
 * @codeCoverageIgnore
 */
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
        'ByRobots\WriteDown\CSRF\CSRFInterface',
        'ByRobots\WriteDown\Sessions\SessionInterface',
        'Zend\Diactoros\Response\EmitterInterface',
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
            ->share('ByRobots\WriteDown\CSRF\CSRFInterface', Hash::class)
            ->withArgument('ByRobots\WriteDown\Sessions\SessionInterface')
            ->withArgument(new Token);

        $this->getContainer()
            ->share('ByRobots\WriteDown\Sessions\SessionInterface', AuraSession::class);
    }
}
