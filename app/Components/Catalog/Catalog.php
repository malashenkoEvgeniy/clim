<?php

namespace App\Components\Catalog;

use App\Components\Catalog\Interfaces\BrandInterface;
use App\Components\Catalog\Interfaces\CategoryInterface;
use App\Components\Catalog\Interfaces\CurrencyInterface;
use App\Components\Catalog\Interfaces\FeatureInterface;
use App\Components\Catalog\Interfaces\LabelInterface;
use Illuminate\Foundation\Application;

/**
 * Class Catalog
 *
 * @package App\Components\Catalog
 */
class Catalog
{

    /**
     * @var Application
     */
    private $app;
    
    public $category;
    public $brand;
    public $currency;
    public $feature;

    /**
     * Catalog constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    
    /**
     * @return null|\App\Components\Catalog\Interfaces\CategoryInterface|\App\Components\Catalog\Interfaces\CatalogBaseInterface
     */
    public function category(): CategoryInterface
    {
        return $this->category;
    }
    
    public function categoriesLoaded(): bool
    {
        return $this->category !== null;
    }
    
    public function loadCategory(CategoryInterface $category): void
    {
        $this->category = $category;
    }
    
    /**
     * @return null|\App\Components\Catalog\Interfaces\FeatureInterface
     */
    public function feature(): FeatureInterface
    {
        return $this->feature;
    }
    
    public function featuresLoaded(): bool
    {
        return $this->feature !== null;
    }
    
    public function loadFeature(FeatureInterface $feature): void
    {
        $this->feature = $feature;
    }

    /**
     * @return null|\App\Components\Catalog\Interfaces\BrandInterface|\App\Components\Catalog\Interfaces\CatalogBaseInterface
     */
    public function brand(): BrandInterface
    {
        return $this->brand;
    }

    public function brandsLoaded(): bool
    {
        return $this->brand !== null;
    }

    public function loadBrands(BrandInterface $brand): void
    {
        $this->brand = $brand;
    }

    /**
     * @return null|\App\Components\Catalog\Interfaces\LabelInterface|\App\Components\Catalog\Interfaces\CatalogBaseInterface
     */
    public function label(): LabelInterface
    {
        return $this->label;
    }

    public function labelsLoaded(): bool
    {
        return $this->label !== null;
    }

    public function loadLabels(LabelInterface $label): void
    {
        $this->label = $label;
    }

    /**
     * @return null|\App\Components\Catalog\Interfaces\CurrencyInterface|\App\Components\Catalog\Interfaces\CatalogBaseInterface
     */
    public function currency(): CurrencyInterface
    {
        return $this->currency;
    }

    public function currenciesLoaded(): bool
    {
        return $this->currency !== null;
    }

    public function loadCurrencies(CurrencyInterface $currency): void
    {
        $this->currency = $currency;
    }

}
