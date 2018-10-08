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
    protected $provides = [
        'Doctrine\ORM\EntityManagerInterface',
        'ByRobots\WriteDown\Auth\Interfaces\AuthInterface'
    ];

    /**
     * Register providers into the container.
     */
    public function register()
    {
        $this->getContainer()->inflector(ControllerInterface::class)
            ->invokeMethod('setRequest', ['Psr\Http\Message\RequestInterface'])
            ->invokeMethod('setSession', ['ByRobots\WriteDown\Sessions\SessionInterface'])
            ->invokeMethod('setAPI', ['ByRobots\WriteDown\API\Interfaces\APIInterface'])
            ->invokeMethod('setCSRF', ['ByRobots\WriteDown\CSRF\CSRFInterface'])
            ->invokeMethod('setAuth', ['ByRobots\WriteDown\Auth\Interfaces\AuthInterface'])
            ->invokeMethod('setMarkdown', ['ByRobots\WriteDown\Markdown\MarkdownInterface']);

        $this->getContainer()->add('Doctrine\ORM\EntityManagerInterface', function() {
            $configBuilder = new DoctrineConfigBuilder;
            $database      = new DoctrineDriver($configBuilder->generate());

            return $database->getManager();
        });

        $this->getContainer()->add('ByRobots\WriteDown\Auth\Interfaces\AuthInterface', Auth::class)
            ->withArgument('Doctrine\ORM\EntityManagerInterface');
    }
}
