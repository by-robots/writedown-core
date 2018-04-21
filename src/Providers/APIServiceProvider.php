<?php

namespace ByRobots\WriteDown\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use ByRobots\WriteDown\API\MetaBuilder;
use ByRobots\WriteDown\API\ResponseBuilder;
use ByRobots\WriteDown\Markdown\Markdown;
use ByRobots\WriteDown\Validator\Valitron;

class APIServiceProvider extends AbstractServiceProvider
{
    /**
     * Services provided by the service provider.
     *
     * @var array
     */
    protected $provides = [
        'ByRobots\WriteDown\API\Interfaces\APIInterface',
        'ByRobots\WriteDown\API\MetaBuilder',
        'ByRobots\WriteDown\API\ResponseBuilder',
        'ByRobots\WriteDown\Markdown\MarkdownInterface',
        'ByRobots\WriteDown\Validator\ValidatorInterface',
    ];

    /**
     * Register providers into the container.
     */
    public function register()
    {
        $this->getContainer()
            ->add('ByRobots\WriteDown\API\Interfaces\APIInterface', 'ByRobots\WriteDown\API\API')
            ->withArgument('Doctrine\ORM\EntityManagerInterface')
            ->withArgument('ByRobots\WriteDown\API\ResponseBuilder')
            ->withArgument('ByRobots\WriteDown\Validator\ValidatorInterface');

        $this->getContainer()
            ->add('ByRobots\WriteDown\API\MetaBuilder', MetaBuilder::class);

        $this->getContainer()
            ->add('ByRobots\WriteDown\API\ResponseBuilder', ResponseBuilder::class)
            ->withArgument('ByRobots\WriteDown\API\MetaBuilder');

        $this->getContainer()
            ->add('ByRobots\WriteDown\Markdown\MarkdownInterface', Markdown::class);

        $this->getContainer()
            ->add('ByRobots\WriteDown\Validator\ValidatorInterface', Valitron::class);
    }
}
