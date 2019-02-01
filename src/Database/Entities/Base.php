<?php

namespace ByRobots\WriteDown\Database\Entities;

/**
 * @property array   $fillable
 * @property array   $rules
 * @property integer $id
 */
class Base
{
    /**
     * Contains the validation rules for the entity.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Columns that can be set by a user.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Attributes that should not be accessible to the object.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get a property if it's accessible. Additionally, if a getter has been
     * manually specified uses that instead.
     *
     * @param string $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        $methodName = "get" . ucfirst($property);

        if (method_exists($this, $methodName)) {
            return call_user_func([$this, $methodName]);
        } else if (
            !in_array($property, $this->hidden) and
            isset($this->{$property})
        ) {
            return $this->{$property};
        }

        return null;
    }

    /**
     * Set a property.
     *
     * @param string $property
     * @param string $value
     *
     * @return void
     */
    public function __set($property, $value)
    {
        $methodName = "set" . ucfirst($property);

        if (method_exists($this, $methodName)) {
            call_user_func([$this, $methodName], $value);
            return;
        }

        $this->$property = $value;
    }

    /**
     * Build an array of key => value pairs for validation.
     *
     * @return array
     */
    public function validationArray()
    {
        $data = [];
        foreach ($this->fillable as $column) {
            if (property_exists($this, $column)) {
                $data[$column] = $this->$column;
            }
        }

        return $data;
    }

    /**
     * Modify rules for updates.
     *
     * @return array
     */
    public function updateRules():array
    {
        $updateRules = $this->rules;

        foreach ($updateRules as $column => $ruleset) {
            foreach ($ruleset as $key => $value) {
                if (is_array($value)) {
                    // $key will contain the rule name, $value the params.
                    switch ($key) {
                        case 'unique_in_database':
                            $updateRules[$column][$key] = array_merge(['except' => $this->id], $value);
                            break;
                    }
                }
            }
        }

        return $updateRules;
    }
}
