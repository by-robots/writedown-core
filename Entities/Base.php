<?php

namespace WriteDown\Entities;

/**
 * @property array $rules
 * @property array $fillable
 */
class Base
{
    /** @Column(name="created_at", type="datetime") */
    protected $created_at;

    /** @Column(name="updated_at", type="datetime") */
    protected $updated_at;

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
            return call_user_func(array($this, $methodName));
        } elseif (isset($this->{$property})) {
            return $this->{$property};
        }

        return null;
    }

    /**
     * Attempt to set a property. Uses an existing setter if available.
     *
     * @param string $property
     * @param mixed  $value
     *
     * @return void
     */
    public function __set($property, $value)
    {
        $methodName = "set" . ucfirst($property);

        if (method_exists($this, $methodName)) {
            call_user_func_array(array($this, $methodName), array($value));
        } else {
            $this->{$property} = $value;
        }
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

    /** @PrePersist */
    public function setCreatedAt()
    {
        $this->created_at = new \DateTime('now');
    }

    /**
     * @PrePersist
     * @PreUpdate
     */
    public function setUpdatedAt()
    {
        $this->updated_at = new \DateTime('now');
    }
}
