<?php

namespace CustomForm\Macro;

use CustomForm\Input;

/**
 * Class Toggle
 *
 * @package CustomForm\Macro
 */
class DatePicker extends Input
{
    
    public function __construct(string $name, $object = null)
    {
        parent::__construct($name, $object);
        
        $this->classes[] = 'datePicker';
    }
    
}
