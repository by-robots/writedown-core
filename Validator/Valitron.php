<?php

namespace WriteDown\Validator;

use Valitron\Validator as Provider;

class Valitron implements ValidatorInterface
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
     * @var \Valitron\Validator
     */
    private $validator;

    /**
     * When a validation has occoured this will contain the result.
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
        $this->validator = $this->validator->withData($this->data);
        $this->validator->rules($this->generateRulesFromProvided());

        $this->success = $this->validator->validate();
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
     * Convert the rules into a Valitron valid array.
     *
     * See https://github.com/vlucas/valitron for details
     *
     * @return array
     */
    private function generateRulesFromProvided()
    {
        $converted = [];
        foreach ($this->rules as $column => $ruleSet) {
            foreach ($ruleSet as $rule) {
                // Split rule details
                $ruleDetails = explode(':', $rule);

                // Create the rule entry
                if (!array_key_exists($ruleDetails[0], $converted)) {
                    $converted[$ruleDetails[0]] = [];
                }

                // Add column that the rule applies to and check if we need to
                // add extra information
                $arguments = [$column];
                if (isset($ruleDetails[1])) {
                    $arguments[] = $ruleDetails[1];
                }

                // Generate the rule
                $converted[$ruleDetails[0]][] = $arguments;
            }
        }

        return $converted;
    }
}
