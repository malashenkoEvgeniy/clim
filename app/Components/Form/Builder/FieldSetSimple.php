<?php

namespace CustomForm\Builder;

use CustomForm\Element;
use Illuminate\Support\Collection;

/**
 * Class FieldSet
 * Field set of form elements
 *
 * @package CustomForm\Builder
 */
class FieldSetSimple
{
    
    /**
     * Fields for current field set
     *
     * @var Collection|Element[]
     */
    private $formFields;
    
    /**
     * FieldSetSimple constructor.
     */
    public function __construct()
    {
        // Generate collection for fields
        $this->formFields = new Collection();
    }
    
    /**
     * Add field to field set
     *
     * @param  Element[] $elements
     * @return $this
     */
    public function add(Element ...$elements)
    {
        // Add fields to field set
        foreach ($elements as $element) {
            $this->formFields->push($element);
        }
        // Return field set object
        return $this;
    }
    
    /**
     * Returns fields collection
     *
     * @return Element[]|Collection
     */
    public function getFields()
    {
        return $this->formFields;
    }
    
}
