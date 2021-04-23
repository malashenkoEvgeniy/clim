<?php

namespace App\Components\Settings;

use CustomForm\Element;

/**
 * Class SettingsElement
 *
 * @package App\Components\Settings
 */
class SettingsElement
{
    
    /**
     * Current element position in the form
     *
     * @var int
     */
    private $position;
    
    /**
     * Rules for validation
     *
     * @var array
     */
    private $rules;
    
    /**
     * Form element to show it to admin
     *
     * @var Element
     */
    private $element;
    
    /**
     * Value
     *
     * @var string
     */
    private $value;
    
    /**
     * SettingsElement constructor.
     *
     * @param Element $element
     * @param array $rules
     * @param int $position
     */
    public function __construct(Element $element, array $rules = [], int $position = 0)
    {
        $this->element = $element;
        $this->value = $this->element->getValue();
        $this->rules = $rules;
        $this->position = $position;
    }
    
    /**
     * Set rules array
     *
     * @param  array $rules
     * @return $this
     */
    public function setRules(array $rules): self
    {
        $this->rules = $rules;
        
        return $this;
    }
    
    /**
     * Get array of rules
     *
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }
    
    /**
     * Set element position in the form
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
     * Get current element position in the form
     *
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }
    
    /**
     * Set value
     *
     * @param  mixed $value
     * @return $this
     */
    public function setValue($value): self
    {
        $this->value = $value;
        $this->element->setValue($this->value);
        
        return $this;
    }
    
    /**
     * Set value from config
     *
     * @param  string $groupAlias
     * @return $this
     */
    public function setValueFromConfig(string $groupAlias): self
    {
        $this->value = config("db.$groupAlias.{$this->element->getName()}");
        $this->element->setValue($this->value);
        
        return $this;
    }
    
    /**
     * Get value
     *
     * @return string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }
    
    /**
     * Get form element to view to the user
     *
     * @return Element
     */
    public function getFormElement(): Element
    {
        return $this->element;
    }
    
    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias(): string
    {
        return $this->element->getName();
    }
    
    /**
     * Set current element as dependent from other field
     *
     * @param string $name
     * @param string $value
     * @return SettingsElement
     */
    public function dependent(string $name, string $value): SettingsElement
    {
        $this->element->setBlockOptions([
            'data-dependent-from' => $name,
            'data-dependent-from-value'=> $value,
        ]);
        $this->element->addClassesToDiv('dependent-field-block');
        
        return $this;
    }
    
    /**
     * Set as master field
     *
     * @return $this
     */
    public function masterField()
    {
        $this->element->setOptions(['data-master']);
    
        return $this;
    }
    
}
