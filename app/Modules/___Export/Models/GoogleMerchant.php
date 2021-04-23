<?php

namespace App\Modules\Export\Models;

use App\Modules\Categories\Models\Category;
use App\Modules\Currencies\Models\Currency;
use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class GoogleMerchant
 * @package App\Modules\Export\Models
 */
class GoogleMerchant
{

    protected $_tree = [];
    protected $_xmlMap = [];

    /**
     * @var Product[]|Collection
     */
    protected $_xmlProducts;
    protected $_imagesXmlMap = [];

    public function getXml()
    {
        if (empty($this->_tree)) {
            $this->buildXml();
        }
        return $this->_tree;
    }

    private function buildXml()
    {
        array_map(function($item) {
            if (!class_exists($item)) {
                return;
            }
            $provider = new $item([]);
            if (!method_exists($provider, 'initSitemap')) {
                return;
            }
            if ( ($parts = $provider->initSitemap()) && is_array($parts) ) {
                foreach ($parts as $part) {
                    $this->_tree[] = $part;
                }
            }
        }, config('app.providers'));
    }

    public function getCurrencies(){
        return Currency::where('default_on_site', 1)
            ->orWhere('default_in_admin_panel', 1)
            ->get();
    }

    public function getGoogleOffersXml()
    {
        if (empty($this->_xmlProducts)) {
            $this->buildGoogleOffersXml();
        }
        return $this->_xmlProducts;
    }

    public function getGoogleCategoriesXml()
    {
        if (empty($this->_xmlCategories)) {
            $this->buildGoogleCategoriesXml();
        }
        return $this->_xmlCategories;
    }

    private function buildGoogleOffersXml()
    {
        $this->_xmlProducts = Product::with(
            'brand',
            'brand.current',
            'current',
            'group.featureValues',
            'group.featureValues.feature',
            'group.featureValues.value.current',
            'group.featureValues.feature.current',
            'images',
            'value',
            'value.current',
            'value.feature',
            'value.feature.current',
            'group',
            'group.mainProduct'
        )
            ->where('active', 1)
            ->get();
    }

    private function buildGoogleCategoriesXml()
    {
        $this->_xmlCategories = Category::where('active', 1)->get();
    }
}
