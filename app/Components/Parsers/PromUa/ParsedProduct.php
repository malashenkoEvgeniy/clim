<?php

namespace App\Components\Parsers\PromUa;

use App\Components\Parsers\AbstractParsedProduct;
use App\Modules\Products\Models\Product;
use PhpOffice\PhpSpreadsheet\Worksheet\RowCellIterator;

/**
 * Class Product
 *
 * @package App\Components\Parsers\PromUa
 */
class ParsedProduct extends AbstractParsedProduct
{
    
    /**
     * @var null|string
     */
    private $brandCountry;
    
    /**
     * @var array
     */
    private $availableStatuses = [
        '+' => Product::AVAILABLE,
        '!' => Product::AVAILABLE,
        '-' => Product::NOT_AVAILABLE,
        '&' => Product::NOT_AVAILABLE,
    ];
    
    /**
     * @var array
     */
    private $synonyms = [
        'Код_товара' => 'vendorCode',
        'Название_позиции' => 'name',
        'Ключевые_слова' => 'keywords',
        'Описание' => 'content',
        'Цена' => 'price',
        'Валюта' => 'remoteCurrency',
        'Единица_измерения' => 'unit',
        'Тип_товара' => 'productType',
        'Минимальный_объем_заказа' => 'minUnits',
        'Оптовая_цена' => 'wholesalePrice',
        'Минимальный_заказ_опт' => 'minUnitsForWholeSale',
        'Количество' => 'minUnitsForOrder',
        'Ссылка_изображения' => 'image',
        'Наличие' => 'available',
        'Скидка' => 'discount',
        'Производитель' => 'brand',
        'Страна_производитель' => 'brandCountry',
        'Номер_группы' => 'remoteCategoryId',
        'Название_группы' => 'categoryName',
        'Адрес_подраздела' => 'categoryUrl',
        'Возможность_поставки' => 'deliveryPossibility',
        'Срок_поставки' => 'deliveryTime',
        'Способ_упаковки' => 'packing',
        'Идентификатор_товара' => 'productId',
        'Уникальный_идентификатор' => 'remoteUniqueIdentifier',
        'Идентификатор_подраздела' => 'remoteCategoryUniqueId',
        'Идентификатор_группы' => 'innerCategoryId',
        'ID_группы_разновидностей' => 'remotePackId',
        'Продукт_на_сайте' => 'productUrl',
        'Метки' => 'labels',
        'Название_Характеристики' => 'feature',
        'Измерение_Характеристики' => 'featureMeasure',
        'Значение_Характеристики' => 'featureValue',
    ];
    
    public static $requiredColumns = [
        'Уникальный_идентификатор', 'Название_позиции', 'Цена', 'Валюта', 'Продукт_на_сайте', 'Идентификатор_подраздела',
    ];
    
    /**
     * @var RowCellIterator
     */
    protected $cellIterator;
    
    /**
     * @var array
     */
    protected $columns;
    
    /**
     * @param RowCellIterator $cellIterator
     * @return ParsedProduct
     */
    public function setCellIterator(RowCellIterator $cellIterator): self
    {
        $this->cellIterator = $cellIterator;
        
        return $this;
    }
    
    /**
     * @param array $columns
     * @return ParsedProduct
     */
    public function setColumns(array $columns): self
    {
        $this->columns = $columns;
        
        return $this;
    }
    
    /**
     * Parsing...
     */
    public function parse(): void
    {
        foreach ($this->cellIterator as $cell) {
            $this->setAttribute($this->columns[$cell->getColumn()], $cell->getValue());
        }
        if ($this->brandCountry) {
            $this->features[] = 'Страна производитель';
            $this->featuresMeasures[] = null;
            $this->featuresValues[] = $this->brandCountry;
        }
    }
    
    /**
     * @param string $promUaPropertyName
     * @param $value
     */
    public function setAttribute(string $promUaPropertyName, $value): void
    {
        if (isset($this->synonyms[$promUaPropertyName])) {
            $this->{$this->synonyms[$promUaPropertyName]} = $value;
        }
    }
    
    /**
     * @param string|null $imagesList
     */
    public function setImageAttribute(?string $imagesList): void
    {
        if (!$imagesList) {
            return;
        }
        $images = explode(',', $imagesList);
        $this->images = array_filter(array_map('trim', $images));
    }
    
    /**
     * @param string|null $feature
     */
    public function setFeatureAttribute(?string $feature): void
    {
        $this->features[] = $feature;
    }
    
    /**
     * @param string|null $measure
     */
    public function setFeatureMeasureAttribute(?string $measure): void
    {
        $this->featuresMeasures[] = $measure;
    }
    
    /**
     * @param string|null $value
     */
    public function setFeatureValueAttribute(?string $value): void
    {
        $this->featuresValues[] = $value;
    }
    
    /**
     * @param string|null $char
     */
    public function setAvailableAttribute(?string $char): void
    {
        $this->availability = array_get($this->availableStatuses, $char, Product::NOT_AVAILABLE);
    }
    
    /**
     * @param int|null $categoryId
     */
    public function setRemoteCategoryIdAttribute(?int $categoryId): void
    {
        $this->remoteCategoryId = $categoryId;
    }
    
    /**
     * @param int|null $categoryId
     */
    public function setInnerCategoryIdAttribute(?int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }
    
    /**
     * @param string|null $currency
     */
    public function setRemoteCurrencyAttribute(?string $currency): void
    {
        if ($currency) {
            $this->currency = array_get($this->currencies, $currency);
        }
    }
    
    /**
     * @param int|null $remoteProductId
     */
    public function setRemoteUniqueIdentifierAttribute(?int $remoteProductId): void
    {
        $this->attributes['remoteUniqueIdentifier'] = (int)$remoteProductId ?: null;
    }
    
}
