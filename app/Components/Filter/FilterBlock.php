<?php

namespace App\Components\Filter;

use Illuminate\Support\Collection;

class FilterBlock
{

    public $id;
    
    public $name;

    public $alias;
    
    public $elements;

    public $position;

    public $showInFilter;
    
    public $count = 0;
    
    public $filteredCount = 0;
    
    public $main = false;
    
    public $showCounter = true;
    
    public function __construct(string $name, string $alias, bool $showInFilter = true, int $position = 0)
    {
        $this->name = $name;
        $this->alias = $alias;
        $this->position = $position;
        $this->showInFilter = $showInFilter;
        $this->elements = new Collection();
    }
    
    public function setId($id): self
    {
        $this->id = $id;
        
        return $this;
    }
    
    public function setAsMain(): self
    {
        $this->main = true;
        
        return $this;
    }
    
    public function setAsMultiple(): self
    {
        $this->showCounter = false;
        
        return $this;
    }
    
    public function addCount(int $count): self
    {
        $this->count += $count;
        
        return $this;
    }
    
    public function isOpen(): bool
    {
        return !config('db.products.filter-counters', true) || (
            $this->filteredCount > 0 ||
            \ProductsFilter::oneOfElementsChosen($this->alias)
        );
    }

    public function addElement(string $name, string $alias): FilterElement
    {
        $element = new FilterElement($this->alias, $name, $alias);
        $this->elements->push($element);

        return $element;
    }
    
    public function addFilteredCount(int $count): self
    {
        $this->filteredCount += $count;
        
        return $this;
    }

    /**
     * @return Collection|FilterElement[]
     */
    public function getElements()
    {
        $enabled = new Collection();
        $disabled = new Collection();
        $this->elements->each(function (FilterElement $element) use ($enabled, $disabled) {
            if ($element->disabled()) {
                $disabled->push($element);
            } else {
                $enabled->push($element);
            }
        });
        $enabled->sortBy('position');
        $disabled->sortBy('position');
        return $enabled->merge($disabled);
    }
    
    /**
     * @return Collection
     */
    public function getElementsWithKey()
    {
        return $this->getElements()->keyBy('alias');
    }
    
    /**
     * @return Collection
     */
    public function getElementsWithIdAsKey()
    {
        return $this->getElements()->keyBy('id');
    }
    
    public function getElementById(int $valueId): ?FilterElement
    {
        return $this->getElementsWithIdAsKey()->get($valueId);
    }
    
    public function showInFilter(): bool
    {
        return
            $this->showInFilter &&
            $this->count > 0 &&
            $this->elements->isNotEmpty();
    }

}
