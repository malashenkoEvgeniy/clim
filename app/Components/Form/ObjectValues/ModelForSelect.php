<?php

namespace App\Components\Form\ObjectValues;

use App\Core\ObjectValues\ObjectValue;
use Illuminate\Support\Collection;

/**
 * Class ModelForSelect
 * Exemplar of this class must be given to Custom\Form::model() method
 *
 * @package App\Components\Form\ObjectValues
 */
class ModelForSelect extends ObjectValue
{
    /**
     * Collection to work with
     *
     * @var Collection|\Illuminate\Database\Eloquent\Collection
     */
    protected $collection;
    
    /**
     * Field name to search value in model
     *
     * @var string
     */
    protected $keyFieldName = 'id';
    
    /**
     * Field name to search title in model
     *
     * @var string
     */
    protected $valueFieldName = 'name';
    
    /**
     * Field name to add relations
     *
     * @var string
     */
    protected $valueFieldRelation;
    
    /**
     * Field name to search parent id
     *
     * @var string
     */
    protected $parentIdKeyFieldName;
    
    /**
     * ModelForSelect constructor.
     *
     * @param Collection|\Illuminate\Database\Eloquent\Collection $collection
     */
    public function __construct($collection)
    {
        $this->collection = $collection;
    }
    
    /**
     * Set property keyFieldName
     *
     * @param string $keyFieldName
     * @return $this
     */
    public function setKeyFieldName(string $keyFieldName)
    {
        $this->keyFieldName = $keyFieldName;
        
        return $this;
    }
    
    /**
     * Set property valueFieldName
     *
     * @param string $valueFieldName
     * @return $this
     */
    public function setValueFieldName(string $valueFieldName)
    {
        $this->valueFieldName = $valueFieldName;
        
        $valueFieldParts = explode('.', $valueFieldName);
        $relation = array_get($valueFieldParts, 0);
        $field = array_get($valueFieldParts, 1);
        if ($field) {
            $this->valueFieldRelation = $relation;
            $this->valueFieldName = $field;
        }
        
        return $this;
    }
    
    /**
     * Check if model needs to load relations
     *
     * @return bool
     */
    public function needsRelation(): bool
    {
        return (bool)$this->getValueFieldRelation();
    }
    
    /**
     * Load missing relations
     *
     * @return ModelForSelect
     */
    public function loadMissing(): self
    {
        $this->collection->loadMissing($this->getValueFieldRelation());
        
        return $this;
    }
    
    /**
     * Set property parentIdKeyFieldName
     *
     * @param string $parentIdKeyFieldName
     * @return $this
     */
    public function setParentIdKeyFieldName(string $parentIdKeyFieldName)
    {
        $this->parentIdKeyFieldName = $parentIdKeyFieldName;
        
        return $this;
    }
    
    /**
     * Returns full collection
     *
     * @return \Illuminate\Database\Eloquent\Collection|Collection
     */
    public function getCollection()
    {
        return $this->collection;
    }
    
    /**
     * Returns keyFieldName
     *
     * @return string
     */
    public function getKeyFieldName()
    {
        return $this->keyFieldName;
    }
    
    /**
     * Returns valueFieldName
     *
     * @return string
     */
    public function getValueFieldName()
    {
        return $this->valueFieldName;
    }
    
    /**
     * Returns parentIdKeyFieldName
     *
     * @return string
     */
    public function getParentIdKeyFieldName()
    {
        return $this->parentIdKeyFieldName;
    }
    
    /**
     * Returns valueFieldRelation
     *
     * @return string
     */
    public function getValueFieldRelation()
    {
        return $this->valueFieldRelation;
    }
    
}