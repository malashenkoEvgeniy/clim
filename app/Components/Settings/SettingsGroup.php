<?php

namespace App\Components\Settings;

use CustomForm\Element;
use Illuminate\Support\Collection;

/**
 * Creates group page with settings
 *
 * @package App\Components\Settings
 */
class SettingsGroup
{
    
    /**
     * Element name in the list of groups page
     *
     * @var string
     */
    private $name;
    
    /**
     * Group alias
     *
     * @var string
     */
    private $alias;
    
    /**
     * Position of the group in the list
     *
     * @var int
     */
    private $position;
    
    /**
     * Collection of current group settings
     *
     * @var Collection|SettingsElement[]
     */
    private $elements;
    
    /**
     * SettingsGroup constructor.
     *
     * @param string $alias
     * @param string $name
     * @param int $position
     */
    public function __construct(string $alias, string $name, int $position = 0)
    {
        $this->elements = new Collection();
        $this->name = $name;
        $this->position = $position;
        $this->alias = $alias;
    }
    
    /**
     * Set group name
     *
     * @param  string $value
     * @return $this
     */
    public function setName(string $value): self
    {
        $this->name = $value;
        
        return $this;
    }
    
    /**
     * Get group name
     *
     * @return string
     */
    public function getName(): string
    {
        return __($this->name);
    }
    
    /**
     * Set group alias
     *
     * @param  string $value
     * @return $this
     */
    public function setAlias(string $value): self
    {
        $this->alias = $value;
        
        return $this;
    }
    
    /**
     * Get group alias
     *
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }
    
    /**
     * Set current group position
     *
     * @param  int $position
     * @return $this
     */
    public function setPosition(int $position): self
    {
        $this->position = $position;
        
        return $this;
    }
    
    /**
     * Get current group position
     *
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }
    
    /**
     * Add setting to current group
     *
     * @param  Element $formElement
     * @param  array $rules
     * @param  int $position
     * @return SettingsElement
     */
    public function add(Element $formElement, array $rules = [], int $position = 0): SettingsElement
    {
        /**
         * @var SettingsElement $element
         */
        if ($this->elements->has($formElement->getName())) {
            // Get element from storage and update data
            $element = $this->elements->get($formElement->getName());
            $element->setRules($rules);
            $element->setPosition($position);
        } else {
            // Create new element and store it
            $element = new SettingsElement($formElement, $rules, $position);
            $this->elements->put($formElement->getName(), $element);
        }
        // Set value
        $element->setValueFromConfig($this->alias);
        // Return value
        return $element;
    }
    
    /**
     * Get all elements
     *
     * @return SettingsElement[]
     */
    public function getAll(): array
    {
        $elements = $this->elements->toArray();
        usort($elements, function (SettingsElement $current, SettingsElement $next) {
            return $current->getPosition() <=> $next->getPosition();
        });
        return $elements;
    }
    
    /**
     * Check if group has elements
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->elements->isEmpty();
    }
    
    /**
     * Check if group has no elements
     *
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return $this->elements->isNotEmpty();
    }
    
    /**
     * Get element from this storage
     *
     * @param  string $alias
     * @param  null $default
     * @return SettingsElement|mixed
     */
    public function get(string $alias, $default = null): SettingsElement
    {
        return $this->elements->get($alias, $default);
    }
    
    /**
     * Get element value
     *
     * @param  string $alias
     * @param  null $default
     * @return SettingsElement|mixed|string
     */
    public function getValue(string $alias, $default = null)
    {
        $element = $this->get($alias, $default);
        if ($element instanceof SettingsElement) {
            return $element->getValue() ?? $default;
        }
        return $element;
    }
    
    /**
     * All rules for current group
     *
     * @return array
     */
    public function getRules(): array
    {
        $rules = [];
        foreach ($this->elements as $element) {
            $rules[$element->getAlias()] = $element->getRules();
        }
        return $rules;
    }
    
}
