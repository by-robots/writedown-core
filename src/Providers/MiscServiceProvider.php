<?php

namespace ByRobots\WriteDown\Providers;

use ByRobots\WriteDown\Auth\Auth;
use ByRobots\WriteDown\Database\DoctrineConfigBuilder;
use ByRobots\WriteDown\Database\DoctrineDriver;
use ByRobots\WriteDown\Http\Interfaces\ControllerInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use ByRobots\WriteDown\Slugs\Slugger;

class MiscServiceProvider extends AbstractServiceProvider
{
    /**
     * Services provided by the service provider.
     *
     * @var array
     */
    protected $provides = ['auth', 'entityManager', 'slugger'];

    /**
     * Register providers into the container.
     */
    public function register()
    {
        $this->getContainer()
            ->add('auth', Auth::class)
            ->withArgument('entityManager');

        $this->getContainer()
            ->add('entityManager', function() {
                $configBuilder = new DoctrineConfigBuilder;
                $database      = new DoctrineDriver($configBuilder->generate());
                return $database->getManager();
            });

        $this->getContainer()
            ->add('slugger', Slugger::class)
            ->withArgument('entityManager');

        $this->getContainer()
            ->inflector(ControllerInterface::class)
           ->invokeMethod('setRequest',  ['request']);
    }
}
