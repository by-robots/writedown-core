<?php

namespace ByRobots\WriteDown\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use ByRobots\WriteDown\Auth\Token;
use ByRobots\WriteDown\CSRF\Hash;
use ByRobots\WriteDown\Sessions\AuraSession;
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
    protected $provides = ['request', 'csrf', 'session', 'emitter'];

    /**
     * Register providers into the container.
     */
    public function register()
    {
        $this->getContainer()->add('request', function() {
            return ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
            );
        });

        $this->getContainer()->add('emitter', SapiEmitter::class);

        $this->getContainer()
            ->share('csrf', Hash::class)
            ->withArgument('session')
            ->withArgument(new Token);

        $this->getContainer()->share('session', AuraSession::class);
    }
}
