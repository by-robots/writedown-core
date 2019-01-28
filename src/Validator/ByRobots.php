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

        // If there are no rules or data throw an exception. Something has gone
        // wrong.
        if (is_null($this->data) or is_null($this->rules)) {
            throw new \Exception('Validation rules, data or both are missing.');
        }

        $result        = $this->validator->validate($this->data, $this->rules);
        $this->success = $result;
        return $this->success();
    }

    /**
     * @inheritDoc
     */
    public function success() : bool
    {
        return $this->success;
    }

    /**
     * @inheritDoc
     */
    public function errors() : array
    {
        $errors = $this->validator->errors();
        return is_array($errors) ? $errors : [];
    }

    /**
     * @inheritDoc
     */
    public function addRule(AbstractRule $rule)
    {
        $this->validator->addRule($rule);
    }

    /**
     * @inheritDoc
     */
    public function addRules(array $rules)
    {
        $this->validator->addRules($rules);
    }
}
