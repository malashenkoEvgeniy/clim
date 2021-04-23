<?php

namespace App\Components\Parsers;

use Illuminate\Support\Collection;

/**
 * Class AbstractParser
 *
 * @package App\Components\Parsers
 */
abstract class AbstractParser
{
    /**
     * @var string
     */
    protected $system = 'prom.ua';
    
    /**
     * @var Collection|AbstractParsedCategory[]
     */
    protected $categories;
    
    /**
     * @var Collection|AbstractParsedProduct[]
     */
    protected $products;
    
    /**
     * @return Collection|AbstractParsedCategory[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }
    
    /**
     * @return Collection|AbstractParsedProduct[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }
    
    /**
     * Current system
     *
     * @return null|string
     */
    public function getSystem(): ?string
    {
        return $this->system;
    }
    
    /**
     * Parsing...
     */
    abstract public function start(): void;
    
    /**
     * @return AbstractParsedCategory
     */
    abstract public function createEmptyParsedCategoryObject(): AbstractParsedCategory;
}
