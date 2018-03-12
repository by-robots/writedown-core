<?php

namespace WriteDown\Entities;

class Base
{
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
    * @param mixed $value
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
}
