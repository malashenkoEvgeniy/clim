<?php

namespace CustomForm\Group;

use Form;
use CustomForm\Element;

/**
 * Checkbox
 *
 * @package CustomForm\Group
 */
class Checkbox extends Element
{
    
    /**
     * Classes on checkbox input
     *
     * @var array
     */
    protected $classes = ['not-minimal'];
    
    /**
     * Classes on checkbox block
     *
     * @var array
     */
    protected $classesOnDiv = ['inline', 'radio'];
    
    /**
     * Render element overload
     *
     * @param  null $value
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Support\HtmlString|\Illuminate\View\View
     */
    public function render($value = null)
    {
        return Form::checkbox(
            $this->getName(),
            $this->getValue(),
            $this->checked($value),
            array_merge(['class' => $this->classes], $this->getOptions())
        );
    }
    
    /**
     * Is element selected?
     *
     * @param  null $value
     * @return bool
     */
    public function checked($value = null)
    {
        if (is_array($value)) {
            return in_array($this->getValue(), $value);
        }
        return $value == $this->getValue();
    }
    
}
