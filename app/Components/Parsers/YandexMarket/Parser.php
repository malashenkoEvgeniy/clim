<?php

namespace App\Components\Parsers\YandexMarket;

use App\Components\Parsers\AbstractParsedCategory;
use App\Components\Parsers\AbstractParser;
use App\Components\Parsers\XML;
use Illuminate\Support\Collection;
use SimpleXMLElement;

/**
 * Class Parser
 *
 * @package App\Components\Parsers\PromUa
 */
class Parser extends AbstractParser
{
    use XML;
    
    /**
     * @var string
     */
    public $url;
    
    /**
     * @var SimpleXMLElement
     */
    public $xml;
    
    /**
     * Import constructor.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->categories = new Collection();
        $this->products = new Collection();
        $this->url = $url;
    }
    
    /**
     * @return AbstractParsedCategory
     */
    public function createEmptyParsedCategoryObject(): AbstractParsedCategory
    {
        return new ParsedCategory();
    }
    
    /**
     * @throws \Exception|\Throwable
     */
    public function start(): void
    {
        $this->xml = new SimpleXMLElement($this->curl($this->url));
        $this->system = $this->xml->shop->url;
        $this->parseCategories();
        $this->parseProducts();
    }
    
    /**
     * @throws \Throwable
     */
    private function parseCategories(): void
    {
        foreach ($this->xml->shop->categories->category as $category) {
            // Parse category row
            $parsedCategory = new ParsedCategory();
            $parsedCategory->setCategoryFromXML($category)->parse();
            // Push to categories list
            $this->categories->push($parsedCategory);
        }
    }
    
    /**
     * @throws \Throwable
     */
    private function parseProducts(): void
    {
        foreach ($this->xml->shop->offers->offer as $offer) {
            // Parse product row
            $parsedProduct = new ParsedProduct($this->system);
            $parsedProduct->setProductFromXML($offer)->parse();
            if (!$parsedProduct->price || !$parsedProduct->currency || !$parsedProduct->productUrl) {
                // This is not a good product
                continue;
            }
            // Push to products list
            $this->products->push($parsedProduct);
        }
    }
    
}
