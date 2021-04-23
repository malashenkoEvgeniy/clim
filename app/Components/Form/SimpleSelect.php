<?php

namespace CustomForm;

use App\Components\Form\ObjectValues\ModelForSelect;
use Illuminate\Support\Collection;

/**
 * SimpleSelect
 *
 * @package CustomForm
 */
class SimpleSelect extends Element
{
    
    protected $template = 'admin.form.select';
    
    /**
     * Collection of choices
     * Choice is an array with  elements:
     * - value: required string or integer
     * - title: required string
     * - attributes: optional array
     *
     * @var Collection
     */
    protected $choices;
    
    /**
     * Do we need to use tree
     *
     * @var bool
     */
    protected $tree = false;
    
    /**
     * Checks if we can choose any element from the tree
     *
     * @var bool
     */
    protected $canChooseGroupElement = false;
    
    /**
     * This is the value of row we should not show to user
     *
     * @var string
     */
    protected $doNotShowElement;
    
    /**
     * Select constructor
     *
     * @param  string $name
     * @param  null $object
     * @throws \App\Exceptions\WrongParametersException
     */
    public function __construct(string $name, $object = null)
    {
        parent::__construct($name, $object);
        // Create choices collection
        $this->choices = new Collection();
    }
    
    /**
     * Add elements to the choices tree
     *
     * @param ModelForSelect $modelForSelect
     * @return Select
     */
    public function model(ModelForSelect $modelForSelect): self
    {
        if ($modelForSelect->getCollection()->count() > 0) {
            $needsRelation = $modelForSelect->needsRelation();
            if ($needsRelation) {
                $modelForSelect->loadMissing();
            }
            $keyName = $modelForSelect->getKeyFieldName();
            $valueName = $modelForSelect->getValueFieldName();
            $relationName = $modelForSelect->getValueFieldRelation();
            $parentId = $modelForSelect->getParentIdKeyFieldName();
            $this->tree = (bool)$parentId;
            foreach ($modelForSelect->getCollection() as $model) {
                $key = $model->{$keyName};
                if ($needsRelation) {
                    $title = $model->{$relationName}->{$valueName};
                } else {
                    $title = $model->{$valueName};
                }
                if ($parentId) {
                    $this->put((int)$model->{$parentId}, $key, $title);
                } else {
                    $this->add([$key => $title]);
                }
            }
        }
        return $this;
    }
    
    /**
     * Put elements to choices
     * This method includes parent_id
     *
     * @param string $where
     * @param string $value
     * @param string $title
     * @return $this
     */
    public function put(string $where, string $value, string $title)
    {
        $elements = $this->choices->get($where, []);
        $elements[] = [
            'value' => $value,
            'title' => $title,
        ];
        $this->choices->put($where, $elements);
        
        return $this;
    }
    
    /**
     * Add list of elements
     * Examples:
     * 1. [1, 2, 3, 4, 5,..]
     * 2. ['dog' => 'Dog', 'cat' => 'Cat',..]
     *
     * @param  array $options
     * @return $this
     */
    public function add(array $options): self
    {
        // Add elements
        foreach ($options as $value => $title) {
            $this->choices->push([
                'value' => $value,
                'title' => $title,
            ]);
        }
        // Return current select exemplar
        return $this;
    }
    
    /**
     * Returns collection of the arrays
     * Example:
     * Collection([value, title], [value, title], [value, title],..)
     *
     * @return Collection
     */
    public function getElements()
    {
        return $this->choices;
    }
    
    /**
     * Returns an array with elements list for render
     *
     * @return array
     */
    public function getList(): array
    {
        if ($this->tree === true) {
            return $this->getListAsTree();
        }
        return $this->getSimpleList();
    }
    
    /**
     * Returns an array with elements list for render
     *
     * @return array
     */
    public function getListAsTree(): array
    {
        return $this->getTreeFor(0);
    }
    
    /**
     * Returns tree for parent $parentId
     *
     * @param string $parentId
     * @param int $depth
     * @return array
     */
    private function getTreeFor(string $parentId, int $depth = 0)
    {
        $space = '';
        if ($this->canChooseGroupElement) {
            $space = str_repeat('&nbsp;', 4 * $depth);
        }
        $list = [];
        foreach ($this->getElements()->get($parentId, []) as $choice) {
            if ($this->doNotShowElement !== null && $choice['value'] == $this->doNotShowElement) {
                continue;
            }
            if ($this->getElements()->has($choice['value'])) {
                if ($this->canChooseGroupElement) {
                    $list[$choice['value']] = $space . __($choice['title']);
                    $list += $this->getTreeFor($choice['value'], ++$depth);
                } else {
                    $list[$choice['title']] = $this->getTreeFor($choice['value']);
                }
            } else {
                $list[$choice['value']] = $space . __($choice['title']);
            }
        }
        return $list;
    }
    
    /**
     * Returns an array with elements list for render
     *
     * @return array
     */
    public function getSimpleList(): array
    {
        $list = [];
        foreach ($this->getElements() as $choice) {
            if ($this->doNotShowElement !== null && $choice['value'] == $this->doNotShowElement) {
                continue;
            }
            $list[$choice['value']] = __($choice['title']);
        }
        return $list;
    }
    
    /**
     * Set new value for property $doNotShowElement
     *
     * @param string $doNotShowElement
     * @return Select
     */
    public function setDoNotShowElement(?string $doNotShowElement): self
    {
        $this->doNotShowElement = $doNotShowElement;
        
        return $this;
    }
    
    /**
     * Set new value for property $doNotShowElement
     *
     * @param bool $canChooseGroupElement
     * @return $this
     */
    public function setCanChooseGroupElement(bool $canChooseGroupElement)
    {
        $this->canChooseGroupElement = $canChooseGroupElement;
        
        return $this;
    }
    
}
