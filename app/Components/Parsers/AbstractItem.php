<?php

namespace App\Components\Parsers;

/**
 * Class AbstractItem
 *
 * @package App\Components\Parsers
 */
abstract class AbstractItem
{
    /**
     * Properties without identification
     *
     * @var array
     */
    protected $attributes = [];
    
    /**
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    public function getAttribute(string $name, $default = null)
    {
        return $this->{$name} ?? $default;
    }
    
    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        $methodName = 'get' . ucfirst($name) . 'Attribute';
        if (method_exists($this, $methodName)) {
            return $this->{$methodName}();
        } elseif (property_exists($this, $name)) {
            return $this->{$name};
        }
        return $this->attributes[$name] ?? null;
    }
    
    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $methodName = 'set' . ucfirst($name) . 'Attribute';
        if (method_exists($this, $methodName)) {
            $this->{$methodName}($value);
        } elseif (property_exists($this, $name)) {
            $this->{$name} = $value;
        } else {
            $this->attributes[$name] = $value;
        }
    }
}
