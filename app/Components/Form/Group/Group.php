<?php

namespace CustomForm\Group;

use CustomForm\Element;
use Illuminate\Support\Collection;

/**
 * Class Group
 * Group of elements. This should be used for radio buttons end checkboxes
 *
 * @package CustomForm\Group
 */
class Group extends Element
{
    
    /**
     * Template to use
     *
     * @var string
     */
    protected $template = 'admin.form.group';
    
    /**
     * Radio buttons or checkboxes list
     *
     * @var Collection|Checkbox[]|Radio[]
     */
    protected $elements;
    
    /**
     * Group constructor.
     *
     * @param  string $name
     * @param  null $object
     * @throws \App\Exceptions\WrongParametersException
     */
    public function __construct(string $name, $object = null)
    {
        parent::__construct($name, $object);
        // Init collection
        $this->elements = new Collection();
    }
    
    /**
     * Add elements to the block
     *
     * @param  Checkbox[]|Radio[]|Element[] $elements
     * @return $this
     */
    public function add(Element ...$elements)
    {
        foreach ($elements as $element) {
            if ($element instanceof Checkbox) {
                $element->name = str_replace('[]', '', $element->name);
            }
            $this->elements->push($element);
        }
        // Return current group
        return $this;
    }
    
    /**
     * Returns elements fo current group
     *
     * @return Checkbox[]|Radio[]|Collection
     */
    public function getElements()
    {
        return $this->elements;
    }
    
}
