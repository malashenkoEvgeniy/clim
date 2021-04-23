<?php

namespace CustomForm\Group;

use Form;
use CustomForm\Element;

/**
 * Radio button
 *
 * @package CustomForm\Group
 */
class Radio extends Element
{
    
    /**
     * Classes on radio input
     *
     * @var array
     */
    protected $classes = ['not-minimal'];
    
    /**
     * Classes on radio block
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
        // Return radio button HTML
        return Form::radio(
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
