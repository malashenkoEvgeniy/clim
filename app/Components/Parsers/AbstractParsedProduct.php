<?php

namespace App\Components\Parsers;

/**
 * Class AbstractParsedProduct
 *
 * @package App\Components\Parsers
 * @property-read string|null $vendorCode
 * @property-read string|null $name
 * @property-read string|null $keywords
 * @property-read string|null $content
 * @property-read string $productType
 * @property-read string|null $unit
 * @property-read int|null $minUnits
 * @property-read int|null $wholesalePrice
 * @property-read int|null $minUnitsForWholeSale
 * @property-read string|null $categoryName
 * @property-read string|null $categoryUrl
 * @property-read string|null $deliveryPossibility
 * @property-read string|null $deliveryTime
 * @property-read int|null $packing
 * @property-read int $remoteUniqueIdentifier
 * @property-read int|null $productId
 * @property-read int|null $remoteCategoryUniqueId
 * @property-read string|null $brand
 * @property-read string|int|null $discount
 * @property-read int|null $remotePackId
 * @property-read string|null $labels
 * @property-read string|null $productUrl
 */
abstract class AbstractParsedProduct extends AbstractItem
{
    /**
     * @var array
     */
    protected $currencies = [
        'UAH' => 'UAH',
        'USD' => 'USD',
        'EUR' => 'EUR',
        'CHF' => 'CHF',
        'RUB' => 'RUB',
        'GBP' => 'GBP',
        'JPY' => 'JPY',
        'PLZ' => 'PLZ',
        'BYN' => 'BYN',
        'KZT' => 'KZT',
        'MDL' => 'MDL',
        'р' => 'RUB',
        'руб' => 'RUB',
        'дол' => 'USD',
        '$' => 'USD',
        'грн' => 'UAH',
    ];
    
    /**
     * Images links list
     *
     * @var array
     */
    public $images = [];
    
    /**
     * @var array
     */
    public $features = [];
    
    /**
     * @var array
     */
    public $featuresMeasures = [];
    
    /**
     * @var array
     */
    public $featuresValues = [];
    
    /**
     * @var float
     */
    public $price;
    
    /**
     * @var int
     */
    public $availability;
    
    /**
     * @var int
     */
    public $remoteCategoryId;
    
    /**
     * @var int|null
     */
    public $categoryId;
    
    /**
     * @var string
     */
    public $currency;
    
    /**
     * Parsing...
     */
    abstract public function parse(): void;
}
