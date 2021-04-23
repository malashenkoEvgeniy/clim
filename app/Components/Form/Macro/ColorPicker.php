<?php

namespace CustomForm\Macro;

use CustomForm\Input;

/**
 * Class ColorPicker
 *
 * @package CustomForm\Macro
 */
class ColorPicker extends Input
{
    
    public function __construct(string $name, $object = null)
    {
        parent::__construct($name, $object);
        
        $this->classes[] = 'my-colorpicker1';
    }
    
}
