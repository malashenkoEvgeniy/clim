<?php

namespace CustomForm\Macro;

use CustomForm\Input;

/**
 * Class Toggle
 *
 * @package CustomForm\Macro
 */
class Slug extends Input
{
    
    protected $template = 'admin.form.macro.slug';
    
    public function __construct(string $name, $object = null)
    {
        parent::__construct($name, $object);
        
        $this->options[] = 'data-slug-button-destination';
    }
    
}
