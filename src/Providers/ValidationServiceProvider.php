<?php

namespace ByRobots\WriteDown\Providers;

use ByRobots\WriteDown\Slugs\GenerateSlug;
use ByRobots\WriteDown\Validator\ByRobots;
use ByRobots\WriteDown\Validator\Rules\Exists;
use ByRobots\WriteDown\Validator\Rules\Unique;
use ByRobots\WriteDown\Validator\Rules\ValidSlug;
use ByRobots\WriteDown\Validator\ValidatorInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ValidationServiceProvider extends AbstractServiceProvider
{
    /**
     * Services provided by the service provider.
     *
     * @var array
     */
    protected $provides = ['validation'];

    /**
     * Register providers into the container.
     */
    public function register()
    {
        $this->getContainer()->add('validation', ByRobots::class);

        $this->getContainer()
            ->inflector(ValidatorInterface::class)
            ->invokeMethod('addRules', [[
                new Exists($this->getContainer()->get('entityManager')),
                new Unique($this->getContainer()->get('entityManager')),
                new ValidSlug(new GenerateSlug),
        ]]);
    }
}
