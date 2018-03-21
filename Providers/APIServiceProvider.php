<?php

namespace WriteDown\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use WriteDown\API\ResponseBuilder;
use WriteDown\Validator\Valitron;

class APIServiceProvider extends AbstractServiceProvider
{
    /**
     * Services provided by the service provider.
     *
     * @var array
     */
    protected $provides = [
        'api',
        'WriteDown\API\ResponseBuilder',
        'WriteDown\Validator\Validator',
    ];

    /**
     * Register providers into the container.
     */
    public function register()
    {
        $this->getContainer()->add('api', 'WriteDown\API\API')
            ->withArgument('Doctrine\ORM\EntityManagerInterface')
            ->withArgument('WriteDown\API\ResponseBuilder')
            ->withArgument('WriteDown\Validator\Validator');

        $this->getContainer()->add('WriteDown\API\ResponseBuilder', ResponseBuilder::class);

        $this->getContainer()->add('WriteDown\Validator\Validator', Valitron::class);
    }
}