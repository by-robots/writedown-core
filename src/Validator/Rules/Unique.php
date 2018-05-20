<?php

namespace ByRobots\WriteDown\Validator\Rules;

use ByRobots\Validation\AbstractRule;
use ByRobots\WriteDown\Database\Interfaces\RepositoryInterface;

class Unique extends AbstractRule
{
    /**
     * @inheritDoc
     */
    protected $name = 'unique_in_database';

    /**
     * @inheritDoc
     */
    protected $messages = [
        'en' => 'is not unique',
    ];

    /**
     * @inheritDoc
     */
    public function validate($field, array $input, array $params = null): bool
    {
        // TODO: Implement validate() method.
    }
}
