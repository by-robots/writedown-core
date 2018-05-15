<?php

namespace ByRobots\WriteDown\Validator;

interface ValidatorInterface
{
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
    public function setRules(array $rules);

    /**
     * Set data to validate.
     *
     * @param array $data
     *
     * @return void
     */
    public function setData(array $data);

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
     * @throws \Exception
     */
    public function validate($rules = null, $data = null) : bool;

    /**
     * Check if the last validation was successful.
     *
     * An exception should be thrown if not validation has occurred.
     *
     * @return boolean
     * @throws \Exception
     */
    public function success() : bool;

    /**
     * Retrieve errors.
     *
     * @return array
     * @throws \Exception
     */
    public function errors() : array;

    /**
     * Add a custom validation rule.
     *
     * @param string   $name
     * @param callback $rule         For now this will need to be tailored
     *                               depending on the validation provider.
     * @param string   $errorMessage
     *
     * @return bool
     */
    public function addRule($name, $rule, $errorMessage);
}
