<?php

namespace App\Core\ObjectValues;

/**
 * Class ObjectValue
 *
 * @package App\Core\ObjectValues
 */
abstract class ObjectValue
{
    
    /**
     * Method to create instance by static method
     */
    public static function make(...$parameters)
    {
        return new static(...$parameters);
    }
    
}
