<?php

namespace App\Components\Parsers\YandexMarket;

use App\Components\Parsers\AbstractParsedProduct;
use App\Components\Parsers\XML;
use Illuminate\Support\Str;
use SimpleXMLElement;

/**
 * Class ParsedProduct
 *
 * @package App\Components\Parsers\YandexMarket
 */
class ParsedProduct extends AbstractParsedProduct
{
    use XML;
    
    /**
     * Тип документа
     *
     * @var string
     */
    protected $type;
    
    /**
     * Site URL
     *
     * @var string
     */
    protected $url;
    
    /**
     * @var SimpleXMLElement
     */
    protected $product;
    
    /**
     * @param SimpleXMLElement $product
     * @return ParsedProduct
     */
    public function setProductFromXML(SimpleXMLElement $product): self
    {
        $this->product = $product;
        
        return $this;
    }
    
    /**
     * ParsedProduct constructor.
     *
     * @param string|null $url
     */
    public function __construct(?string $url = null)
    {
        $this->url = $url;
    }
    
    /**
     * Parsing...
     */
    public function parse(): void
    {
        if (isset($this->product['type'])) {
            $this->type = (string)$this->product['type'];
        }
        $this->currency = $this->getElementFromProperty($this->product, 'currencyId');
        $this->remoteUniqueIdentifier = $this->getElementFromAttribute($this->product, 'id', 'int');
        $this->remoteCategoryId = $this->getElementFromProperty($this->product, 'categoryId', 'int');
        $this->price = $this->getElementFromProperty($this->product, 'price', 'float', 0);
        $this->content = $this->getElementFromProperty($this->product, 'description');
        $this->parseName();
        $this->parseFeatures();
        $this->parseImages();
        $this->availability = $this->getElementFromAttribute($this->product, 'available', 'boolean', true);
        $this->productUrl = $this->getElementFromProperty($this->product, 'url');
        $this->brand = $this->getElementFromProperty($this->product, 'vendor');
        $this->vendorCode = $this->getElementFromProperty($this->product, 'vendorCode');
        $this->keywords = $this->getElementFromProperty($this->product, 'keywords');
        $this->country_of_origin = $this->getElementFromProperty($this->product, 'country_of_origin');
        $this->sale = $this->getElementFromProperty($this->product, 'sale', 'int');
        $this->store = $this->getElementFromProperty($this->product, 'store', 'boolean');
        $this->delivery = $this->getElementFromProperty($this->product, 'delivery', 'boolean');
        $this->typePrefix = $this->getElementFromProperty($this->product, 'typePrefix');
        $this->manufacturer_warranty = $this->getElementFromProperty($this->product, 'manufacturer_warranty', 'boolean');
        $this->pickup = $this->getElementFromProperty($this->product, 'pickup', 'boolean');
        $this->sales_notes = $this->getElementFromProperty($this->product, 'sales_notes');
        $this->barcode = $this->getElementFromProperty($this->product, 'barcode');
        $this->quantity = $this->getElementFromProperty($this->product, 'quantity');
        $this->collection = $this->getElementFromProperty($this->product, 'collection');
    }
    
    /**
     * Парсим название продукта
     *
     * @return string
     */
    private function parseName()
    {
        if ($this->type === 'vendor.model' && isset($this->product->model)) {
            return $this->name = (string)$this->product->model;
        }
        if (isset($this->product->name)) {
            return $this->name = (string)$this->product->name;
        }
        return null;
    }
    
    /**
     * Parse features
     */
    private function parseFeatures()
    {
        if (!isset($this->product->param) || empty($this->product->param)) {
            return;
        }
        foreach ($this->product->param as $element) {
            if (!isset($element['name'])) {
                continue;
            }
            $value = trim((string)$element);
            if (!$value) {
                continue;
            }
            $feature = trim((string)$element['name']);
            $this->features[] = $feature;
            $this->featuresMeasures[] = null;
            $this->featuresValues[] = trim((string)$element);
        }
    }
    
    /**
     * Parse images
     */
    private function parseImages()
    {
        if (!isset($this->product->picture) || empty($this->product->picture)) {
            return;
        }
        foreach ($this->product->picture as $picture) {
            $picture = trim((string)$picture);
            if (!$picture) {
                continue;
            }
            if (Str::startsWith($picture, 'http')) {
                $this->images[] = $picture;
            } elseif($this->url) {
                $this->images[] = trim($this->url, '/') . '/' . trim($picture, '/');
            }
        }
    }
}
