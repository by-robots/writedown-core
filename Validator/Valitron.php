<?php

namespace WriteDown\Validator;

use Valitron\Validator as Provider;

class Valitron implements Validator
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
     * Set rules to validate against.
     *
     * Format should be as follows:
     * [
     *     'column 1' => ['required', 'unique'],
     *     'column x' => ['numeric'],
     * ]
     *
     * @param array $rules
     *
     * @return void
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * Set data to validate.
     *
     * @param array $data
     *
     * @return void
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * Validate data. Optionally allows $rules and $data to be set here. If not,
     * uses $this->rules and $this->data.
     *
     * Should $this->rules or $this->data not be available an exception must be
     * thrown.
     *
     * Returns true on validation success, false on failure.
     *
     * @param array $rules
     * @param array $data
     *
     * @return bool
     */
    public function validate($rules = null, $data = null)
    {
        // If $rules or $data is provided here then squirrel it away
        if (!is_null($rules)) {
            $this->rules = $rules;
        }

        if (!is_null($data)) {
            $this->data = $data;
        }

        // Run the validation
        $this->validator = new Provider($this->data);
        foreach ($this->generateRulesFromProvided() as $rule => $columns) {
            $this->validator->rule($rule, $columns);
        }

        $this->success = $this->validator->validate();
        return $this->success();
    }

    /**
     * Check if the last validation was successful.
     *
     * An exception should be thrown if not validation has occoured.
     *
     * @return boolean
     * @throws \Exception
     */
    public function success()
    {
        if (is_null($this->validator)) {
            throw new \Exception('No validation processed.');
        }

        return $this->success;
    }

    /**
     * Retrieve errors.
     *
     * Throws an exception when no errors are available.
     *
     * @return array
     * @throws \Exception
     */
    public function errors()
    {
        if (is_null($this->validator)) {
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
                if (!array_key_exists($rule, $converted)) {
                    $converted[$rule] = [];
                }

                $converted[$rule][] = $column;
            }
        }

        return $converted;
    }
}
