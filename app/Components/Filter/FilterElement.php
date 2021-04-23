<?php

namespace App\Components\Filter;

use ProductsFilter;

class FilterElement
{

    public $id;
    
    public $name;

    public $alias;

    public $parentAlias;
    
    /**
     * @var FilterBlock|null
     */
    public $parentBlock;

    public $selected;

    public $count = 0;
    
    public $filteredCount = 0;
    
    public $linkedToProduct = false;

    public function __construct(string $parentAlias, string $name, string $alias)
    {
        $this->parentAlias = $parentAlias;
        $this->name = $name;
        $this->alias = $alias;
        $this->selected = ProductsFilter::chosen($parentAlias, $alias);
        $this->parentBlock = ProductsFilter::getBlock($this->parentAlias);
    }

    public function link(): string
    {
        if ($this->selected) {
            return ProductsFilter::linkWithout($this->parentAlias, $this->alias);
        }
        return ProductsFilter::linkWith($this->parentAlias, $this->alias);
    }

    public function linkSitemap(string $route, array $categoryParams): string
    {
        return ProductsFilter::linkWithSitemap($this->parentAlias, $this->alias, $route, $categoryParams);
    }
    
    public function setId(int $id): self
    {
        $this->id = $id;
        
        return $this;
    }
    
    public function addCount(int $count): self
    {
        $this->count += $count;
        
        return $this;
    }
    
    public function addFilteredCount(int $count): self
    {
        $this->filteredCount += $count;
    
        return $this;
    }
    
    public function showInFilter(): bool
    {
        return $this->count > 0;
    }
    
    public function filteredCountToShow(): string
    {
        if (
            !config('db.products.filter-counters', true) ||
            $this->selected ||
            !$this->filteredCount ||
            (
                $this->parentBlock &&
                $this->parentBlock->main
            ) ||
            !$this->parentBlock->showCounter
        ) {
            return '';
        }
        if (ProductsFilter::oneOfElementsChosen($this->parentAlias)) {
            return '(+' . $this->filteredCount . ')';
        }
        return '(' . $this->filteredCount . ')';
    }
    
    public function disabled(): bool
    {
        return
            config('db.products.filter-counters', true) &&
            $this->filteredCount === 0 &&
            !$this->selected;
    }

}
