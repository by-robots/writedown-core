<?php

namespace WriteDown\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use WriteDown\Auth\Auth;
use WriteDown\Database\DoctrineConfigBuilder;
use WriteDown\Database\DoctrineDriver;
use WriteDown\Http\Interfaces\ControllerInterface;

class MiscServiceProvider extends AbstractServiceProvider
{
    /**
     * Services provided by the service provider.
     *
     * @var array
     */
    protected $provides = [
        'Doctrine\ORM\EntityManagerInterface',
        'WriteDown\Auth\Interfaces\AuthInterface'
    ];

    /**
     * Register providers into the container.
     */
    public function register()
    {
        $this->getContainer()->inflector(ControllerInterface::class)
            ->invokeMethod('setRequest',  ['Psr\Http\Message\RequestInterface'])
            ->invokeMethod('setResponse', ['Psr\Http\Message\ResponseInterface'])
            ->invokeMethod('setSessions', ['WriteDown\Sessions\SessionInterface'])
            ->invokeMethod('setAPI',      ['WriteDown\API\Interfaces\APIInterface'])
            ->invokeMethod('setView',     ['view']) // TODO: Interface
            ->invokeMethod('setCSRF',     ['WriteDown\CSRF\CSRFInterface'])
            ->invokeMethod('setAuth',     ['WriteDown\Auth\Interfaces\AuthInterface'])
            ->invokeMethod('setMarkdown', ['WriteDown\Markdown\MarkdownInterface']);

        $this->getContainer()->add('Doctrine\ORM\EntityManagerInterface', function() {
            $configBuilder = new DoctrineConfigBuilder;
            $database      = new DoctrineDriver(
                $configBuilder->generate()
            );

            return $database->getManager();
        });

        $this->getContainer()->add('WriteDown\Auth\Interfaces\AuthInterface', Auth::class)
            ->withArgument('Doctrine\ORM\EntityManagerInterface');
    }
}
