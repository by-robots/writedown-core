<?php

namespace ByRobots\WriteDown\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use ByRobots\WriteDown\API\MetaBuilder;
use ByRobots\WriteDown\API\ResponseBuilder;
use ByRobots\WriteDown\Markdown\Markdown;

class APIServiceProvider extends AbstractServiceProvider
{
    /**
     * Services provided by the service provider.
     *
     * @var array
     */
    protected $provides = ['api', 'metaBuilder', 'responseBuilder', 'markdown'];

    /**
     * Register providers into the container.
     */
    public function register()
    {
        $this->getContainer()
            ->add('api', 'ByRobots\WriteDown\API\API')
            ->withArgument('entityManager')
            ->withArgument('responseBuilder')
            ->withArgument('validation');

        $this->getContainer()->add('metaBuilder', MetaBuilder::class);

        $this->getContainer()
            ->add('responseBuilder', ResponseBuilder::class)
            ->withArgument('metaBuilder');

        $this->getContainer()->add('markdown', Markdown::class);
    }
}
