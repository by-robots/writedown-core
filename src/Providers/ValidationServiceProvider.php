<?php

namespace ByRobots\WriteDown\Providers;

use ByRobots\WriteDown\Slugs\GenerateSlug;
use ByRobots\WriteDown\Validator\ByRobots;
use ByRobots\WriteDown\Validator\Rules\Unique;
use ByRobots\WriteDown\Validator\Rules\ValidSlug;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ValidationServiceProvider extends AbstractServiceProvider
{
    /**
     * Services provided by the service provider.
     *
     * @var array
     */
    protected $provides = [
        'ByRobots\WriteDown\Validator\ValidatorInterface',
    ];

    /**
     * Register providers into the container.
     */
    public function register()
    {
        $this->getContainer()
                ->add('ByRobots\WriteDown\Validator\ValidatorInterface', ByRobots::class);

        $this->getContainer()
                ->inflector('ByRobots\WriteDown\Validator\ValidatorInterface')
                ->invokeMethod('addRules', [[
                    new Unique($this->getContainer()->get('Doctrine\ORM\EntityManagerInterface')),
                    new ValidSlug(new GenerateSlug),
            ]]);
    }
}
