<?php

namespace ByRobots\WriteDown\Providers;

use ByRobots\WriteDown\Validator\Valitron;
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
		     ->add('ByRobots\WriteDown\Validator\ValidatorInterface', Valitron::class);
	}
}
