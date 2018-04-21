<?php

namespace WriteDown\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use WriteDown\Auth\Token;
use WriteDown\CSRF\Hash;
use WriteDown\Sessions\AuraSession;
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
        'WriteDown\CSRF\CSRFInterface',
        'WriteDown\Sessions\SessionInterface',
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
            ->share('WriteDown\CSRF\CSRFInterface', Hash::class)
            ->withArgument('WriteDown\Sessions\SessionInterface')
            ->withArgument(new Token);

        $this->getContainer()
            ->share('WriteDown\Sessions\SessionInterface', AuraSession::class);
    }
}
