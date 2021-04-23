<?php

namespace App\Components\Parsers\YandexMarket;

use App\Components\Parsers\AbstractParsedCategory;
use App\Components\Parsers\XML;
use SimpleXMLElement;

/**
 * Class Category
 *
 * @package App\Components\Parsers\YandexMarket
 */
class ParsedCategory extends AbstractParsedCategory
{
    use XML;
    
    /**
     * @var SimpleXMLElement
     */
    protected $category;
    
    /**
     * @param SimpleXMLElement $category
     * @return ParsedCategory
     */
    public function setCategoryFromXML(SimpleXMLElement $category): self
    {
        $this->category = $category;
        
        return $this;
    }
    
    /**
     * Parsing...
     */
    public function parse(): void
    {
        if (!$this->category) {
            throw new \Exception('Please specify category!');
        }
        $this->categoryName = trim((string)$this->category);
        $this->remoteCategoryId = $this->getElementFromAttribute($this->category, 'id', 'int');
        $this->remoteParentId = $this->getElementFromAttribute($this->category, 'parentId', 'int');
    }
    
}
