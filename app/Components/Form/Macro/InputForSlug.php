<?php

namespace CustomForm\Macro;

use CustomForm\Input;

/**
 * Class Toggle
 *
 * @package CustomForm\Macro
 */
class InputForSlug extends Input
{
    
    public function __construct(string $name, $object = null)
    {
        parent::__construct($name, $object);
        
        $this->options[] = 'data-slug-button-origin';
    }
    
}
