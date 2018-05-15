<?php

namespace ByRobots\WriteDown\Providers;

use ByRobots\WriteDown\Validator\ValidatorInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use ByRobots\WriteDown\Validator\Valitron;

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

		// Get an instance of the data source. This will be needed for checking
		// uniqueness
		$database = $this->getContainer()->get('Doctrine\ORM\EntityManagerInterface');
		$this->getContainer()->inflector(ValidatorInterface::class)
		     ->invokeMethod('addRule', [
			     'unique',
			     function ($field, $value, array $params, array $fields) use ($database) {
				     // Validate that the field is unique. Optionally an ID
				     // can be specified in $params so, in the case of updates,
				     // a specific row can be excluded from the check.
			     },
			     '{$field} is not unique.',
		     ]);
	}
}
