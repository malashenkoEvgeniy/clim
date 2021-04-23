<?php

namespace CustomForm\Macro;

use CustomForm\Input;

/**
 * Class Toggle
 *
 * @package CustomForm\Macro
 */
class DateTimePicker extends Input
{
    
    public function __construct(string $name, $object = null)
    {
        parent::__construct($name, $object);
        
        $this->classes[] = 'dateTimePicker';
    }
    
}
