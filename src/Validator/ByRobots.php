<?php

namespace ByRobots\WriteDown\Validator;

use ByRobots\Validation\AbstractRule;
use ByRobots\Validation\Validation as Provider;

class ByRobots implements ValidatorInterface
{
    /**
     * Contains the rules to validate against.
     *
     * @var array
     */
    private $rules;

    /**
     * Contains the data to validate.
     *
     * @var array
     */
    private $data;

    /**
     * The validator provider.
     *
     * @var \ByRobots\Validation\Validation
     */
    private $validator;

    /**
     * When a validation has occurred this will contain the result.
     *
     * @var boolean
     */
    private $success = null;

    /**
     * Allez! Allez!
     *
     * @return void
     */
    public function __construct()
    {
        $this->validator = new Provider;
    }

    /**
     * @inheritDoc
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @inheritDoc
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function validate($rules = null, $data = null) : bool
    {
        // If $rules or $data is provided here then squirrel it away
        if (!is_null($rules)) {
            $this->setRules($rules);
        }

        if (!is_null($data)) {
            $this->setData($data);
        }

        // Run the validation
        $result        = $this->validator->validate($this->data, $this->rules);
        $this->success = $result;
        return $this->success();
    }

    /**
     * @inheritDoc
     */
    public function success() : bool
    {
        if (is_null($this->success)) {
            throw new \Exception('No validation processed.');
        }

        return $this->success;
    }

    /**
     * @inheritDoc
     */
    public function errors() : array
    {
        if (is_null($this->success)) {
            throw new \Exception('No validation processed.');
        }

        return $this->validator->errors();
    }

    /**
     * @inheritDoc
     */
    public function addRule(AbstractRule $rule)
    {
        $this->validator->addRule($rule);
    }
}
