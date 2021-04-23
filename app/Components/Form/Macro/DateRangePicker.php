<?php

namespace CustomForm\Macro;

use CustomForm\Input;

/**
 * Class DateRangePicker
 * @package CustomForm\Macro
 */
class DateRangePicker extends Input
{
    
    public function __construct(string $name, $object = null)
    {
        parent::__construct($name, $object);
        
        $this->classes[] = 'dateRangePicker';
    }
    
}
