<?php

namespace CustomForm\Builder;

use CustomForm\Element;
use Illuminate\Support\Collection;

/**
 * Class Tab
 *
 * @package App\Components\Form\Builder
 */
class Tab
{
    /**
     * @var string
     */
    protected $name;
    
    /**
     * @var string
     */
    protected $id;
    
    /**
     * Form field sets
     *
     * @var Collection|FieldSet[]|FieldSetLang[]|FieldSetSimple[]|ViewSet[]|Tabs[]
     */
    private $fieldSets;
    
    /**
     * Tab constructor.
     *
     * @param string $name
     * @param null|string $id
     * @throws \Exception
     */
    public function __construct(string $name, ?string $id = null)
    {
        $this->name = $name;
        $this->id = (string)$id ?: 'tab_' . random_int(100000, 999999);
        $this->fieldSets = new Collection();
    }
    
    /**
     * @return FieldSetSimple
     */
    public function simpleFieldSet()
    {
        // Create field set
        $fieldSet = new FieldSetSimple();
        // Store it
        $this->fieldSets->push($fieldSet);
        // Return it to main function
        return $fieldSet;
    }
    
    /**
     * @param  int $width
     * @param  string|null $color
     * @param  string|null $title
     * @return FieldSet
     */
    public function fieldSet(int $width = 12, $color = null, $title = null)
    {
        // Create field set
        $fieldSet = new FieldSet($width, $color, $title);
        // Store it
        $this->fieldSets->push($fieldSet);
        // Return it to main function
        return $fieldSet;
    }
    
    /**
     * @param FieldSet $fieldSet
     * @return FieldSet
     */
    public function addFieldSet(FieldSet $fieldSet): FieldSet
    {
        $this->fieldSets->push($fieldSet);
        
        return $fieldSet;
    }
    
    /**
     * @param  int $width
     * @param  string|null $color
     * @param  string|null $title
     * @return FieldSetLang
     */
    public function fieldSetForLang(int $width = 12, $color = null, $title = null)
    {
        // Create field set
        $fieldSet = new FieldSetLang($width, $color, $title);
        // Store it
        $this->fieldSets->push($fieldSet);
        // Return it to main function
        return $fieldSet;
    }
    
    /**
     * @param FieldSetLang $fieldSet
     * @return FieldSetLang
     */
    public function addFieldSetForLang(FieldSetLang $fieldSet): FieldSetLang
    {
        $this->fieldSets->push($fieldSet);
        
        return $fieldSet;
    }
    
    /**
     * @param null $color
     * @param null $title
     * @return FieldSet
     */
    public function fieldSetForFilter($color = null, $title = null)
    {
        // Create field set
        $fieldSet = new FieldSet(0, $color ?? FieldSet::COLOR_PRIMARY, $title);
        // Store it
        $this->fieldSets->push($fieldSet);
        // Return it to main function
        return $fieldSet;
    }
    
    /**
     * @param int $width
     * @param string $path
     * @param array $params
     * @return ViewSet
     */
    public function fieldSetForView($path, $params = [], int $width = 12)
    {
        // Create field set
        $viewSet = new ViewSet($path, $params, $width);
        // Store it
        $this->fieldSets->push($viewSet);
        // Return it to main function
        return $viewSet;
    }
    
    /**
     * Returns all field sets
     *
     * @return FieldSet[]|Collection
     */
    public function getFieldSets()
    {
        return $this->fieldSets;
    }
    
    public function getName(): string
    {
        return __($this->name);
    }
    
    public function getId(): string
    {
        return $this->id;
    }
    
}