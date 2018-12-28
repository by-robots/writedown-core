<?php

namespace ByRobots\WriteDown\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use ByRobots\WriteDown\Auth\Auth;
use ByRobots\WriteDown\Database\DoctrineConfigBuilder;
use ByRobots\WriteDown\Database\DoctrineDriver;
use ByRobots\WriteDown\Http\Interfaces\ControllerInterface;

class MiscServiceProvider extends AbstractServiceProvider
{
    /**
     * Services provided by the service provider.
     *
     * @var array
     */
    protected $provides = ['entityManager', 'auth'];

    /**
     * Register providers into the container.
     */
    public function register()
    {
        $this->getContainer()->inflector(ControllerInterface::class)
            ->invokeMethod('setRequest', ['request'])
            ->invokeMethod('setResponse', ['response'])
            ->invokeMethod('setSession', ['session'])
            ->invokeMethod('setAPI', ['api'])
            ->invokeMethod('setCSRF', ['csrf'])
            ->invokeMethod('setAuth', ['auth'])
            ->invokeMethod('setMarkdown', ['markdown']);

        $this->getContainer()->add('entityManager', function() {
            $configBuilder = new DoctrineConfigBuilder;
            $database      = new DoctrineDriver($configBuilder->generate());

            return $database->getManager();
        });

        $this->getContainer()->add('auth', Auth::class)
            ->withArgument('entityManager');
    }
}
