<?php

namespace CustomForm\Macro;

use CustomForm\Select;

/**
 * Class MultiSelect
 *
 * @package CustomForm\Macro
 */
class MultiSelect extends Select
{
    public function __construct(string $name, $object = null)
    {
        parent::__construct($name, $object);
        
        $this->options['multiple'] = 'multiple';
        $this->classes[] = 'select2';
    }
    
    /**
     * Set multiple values
     *
     * @param  array|int|null|string $value
     * @return Select
     */
    public function setValue($value)
    {
        if (is_array($value) === false) {
            $value = [$value];
        }
        return parent::setValue($value);
    }
    
    public function render()
    {
        $this->setOptions(['style' => 'display: none;']);
        $placeholder = $this->getPlaceholder();
        if ($placeholder) {
            $this->setOptions(['data-placeholder' => $placeholder]);
        }
        return parent::render();
    }
}
