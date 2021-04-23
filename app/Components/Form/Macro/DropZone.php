<?php

namespace CustomForm\Macro;

use CustomForm\Element;

/**
 * Class ColorPicker
 *
 * @package CustomForm\Macro
 */
class DropZone extends Element
{
    
    public function __construct(string $name, $object = null)
    {
        parent::__construct($name, $object);
    }
    
    public function render()
    {
        if (!$this->object) {
            return null;
        }
        return \App\Core\Modules\Images\Components\DropZone::make($this->object)->render();
    }
    
}
