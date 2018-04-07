<?php

namespace WriteDown\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use WriteDown\API\MetaBuilder;
use WriteDown\API\ResponseBuilder;
use WriteDown\Markdown\Markdown;
use WriteDown\Validator\Valitron;

class APIServiceProvider extends AbstractServiceProvider
{
    /**
     * Services provided by the service provider.
     *
     * @var array
     */
    protected $provides = [
        'WriteDown\API\Interfaces\APIInterface',
        'WriteDown\API\MetaBuilder',
        'WriteDown\API\ResponseBuilder',
        'WriteDown\Markdown\MarkdownInterface',
        'WriteDown\Validator\ValidatorInterface',
    ];

    /**
     * Register providers into the container.
     */
    public function register()
    {
        $this->getContainer()
            ->add('WriteDown\API\Interfaces\APIInterface', 'WriteDown\API\API')
            ->withArgument('Doctrine\ORM\EntityManagerInterface')
            ->withArgument('WriteDown\API\ResponseBuilder')
            ->withArgument('WriteDown\Validator\ValidatorInterface');

        $this->getContainer()
            ->add('WriteDown\API\MetaBuilder', MetaBuilder::class);

        $this->getContainer()
            ->add('WriteDown\API\ResponseBuilder', ResponseBuilder::class)
            ->withArgument('WriteDown\API\MetaBuilder');

        $this->getContainer()
            ->add('WriteDown\Markdown\MarkdownInterface', Markdown::class);

        $this->getContainer()
            ->add('WriteDown\Validator\ValidatorInterface', Valitron::class);
    }
}
