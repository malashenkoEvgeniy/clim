<?php

namespace App\Modules\Products;

use App\Core\BaseProvider;
use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\Modules\Languages\Models\Language;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductGroup;
use App\Modules\Products\Models\ProductTranslates;
use App\Modules\Products\Widgets\ProductAmount;
use App\Modules\Products\Widgets\ProductAmountOld;
use App\Modules\Products\Widgets\ProductOrderMail;
use App\Modules\Products\Widgets\Site\CompareProductCard;
use App\Modules\Products\Widgets\Site\CompareProductsList;
use App\Modules\Products\Widgets\Site\CompareProductsListAll;
use App\Modules\Products\Widgets\Site\MicroDataSearchBar;
use App\Modules\Products\Widgets\Site\ProductCartItem;
use App\Modules\Products\Widgets\Site\ProductDescription;
use App\Modules\Products\Widgets\Site\ProductGroupDescription;
use App\Modules\Products\Widgets\Site\ProductFilterChosen;
use App\Modules\Products\Widgets\Site\ProductFilterPrice;
use App\Modules\Products\Widgets\ProductInvoice;
use App\Modules\Products\Widgets\ProductGroupLiveSearchSelect;
use App\Modules\Products\Widgets\Site\ProductCard;
use App\Modules\Products\Widgets\Site\ProductControls;
use App\Modules\Products\Widgets\Site\ProductFilter;
use App\Modules\Products\Widgets\Site\ProductGroupCard;
use App\Modules\Products\Widgets\Site\ProductGroupList;
use App\Modules\Products\Widgets\Site\ProductGroupSlider;
use App\Modules\Products\Widgets\Site\ProductImage;
use App\Modules\Products\Widgets\Site\ProductInCheckout;
use App\Modules\Products\Widgets\Site\ProductOrder;
use App\Modules\Products\Widgets\Site\ProductPage\ProductTabDescription;
use App\Modules\Products\Widgets\Site\ProductPage\ProductTabFeatures;
use App\Modules\Products\Widgets\Site\ProductPage\ProductTabDescFeatures;
use App\Modules\Products\Widgets\Site\ProductPage\ProductTabMain;
use App\Modules\Products\Widgets\Site\ProductPage\ProductTabReviews;
use App\Modules\Products\Widgets\Site\ProductPrice;
use App\Modules\Products\Widgets\Site\ProductPrintOrder;
use App\Modules\Products\Widgets\Site\ProductsList;
use App\Modules\Products\Widgets\Site\ProductsListBrandPage;
use App\Modules\Products\Widgets\Site\ProductsListCategoryPage;
use App\Modules\Products\Widgets\Site\ProductsSlider;
use App\Modules\Products\Widgets\Site\ProductsViewedPage;
use App\Modules\Products\Widgets\Site\ProductsWishlistPage;
use App\Modules\Products\Widgets\Site\SearchBar;
use App\Modules\Products\Widgets\Site\SortProductsBar;
use App\Modules\Products\Widgets\Site\MobileButton;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomForm\TinyMce;
use CustomForm\WysiHtml5;
use CustomSettings,
    CustomRoles,
    CustomMenu,
    Widget;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Catalog
 */
class Provider extends BaseProvider
{

    /**
     * Set custom presets
     */
    protected function presets()
    {
    }

    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        // Register role scopes
        CustomRoles::add('products', 'products::general.permission-name')
            ->except(RoleRule::VIEW)
            ->addCustomPolicy('groups', RoleRule::UPDATE)
            ->addCustomPolicy('deleteImage', RoleRule::UPDATE)
            ->addCustomPolicy('setAsMain', RoleRule::UPDATE)
            ->addCustomPolicy('linkFeatureValueToGroup', RoleRule::UPDATE)
            ->addCustomPolicy('changeFeature', RoleRule::UPDATE)
            ->addCustomPolicy('changeFeatureConfirmation', RoleRule::UPDATE)
            ->addCustomPolicy('cloneProduct', RoleRule::STORE)
            ->addCustomPolicy('linkFeatureValue', RoleRule::UPDATE);
        CustomRoles::linkGroup('products', 'groups');

        $group = CustomMenu::get()->group();
        $group
            ->block('catalog')
            ->link('products::menu.groups', RouteObjectValue::make('admin.groups.index'))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.groups.create'),
                RouteObjectValue::make('admin.groups.change-feature'),
                RouteObjectValue::make('admin.groups.edit')
            )
            ->setPermissionScope('products.index');
        $group
            ->block('catalog', 'products::menu.block', 'fa fa-cubes')
            ->setPosition(-999)
            ->link('products::menu.products', RouteObjectValue::make('admin.products.index'))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.products.create'),
                RouteObjectValue::make('admin.products.edit')
            );

        // Register module configurable settings
        $settings = CustomSettings::createAndGet('microdata', 'products::settings.microdata');
        $settings->add(
            Toggle::create('search')
                ->setLabel('products::settings.attributes.microdata-search')
                ->setDefaultValue(true)
                ->required(),
            ['required', 'boolean']
        );
        $settings->add(
            Toggle::create('product')
                ->setLabel('products::settings.attributes.microdata-product')
                ->setDefaultValue(true)
                ->required(),
            ['required', 'boolean']
        );

        $settings = CustomSettings::createAndGet('products', 'products::settings.group-name');
        $settings->add(
            Toggle::create('filter-counters')
                ->setLabel('products::settings.attributes.filter-counters')
                ->setDefaultValue(true)
                ->required(),
            ['required', 'boolean']
        );
        $settings->add(
            Input::create('per-page')
                ->setType('number')
                ->setLabel('products::settings.attributes.per-page')
                ->setDefaultValue(ProductGroup::LIMIT_PER_PAGE_BY_DEFAULT_ADMIN_PANEL)
                ->required(),
            ['required', 'integer', 'min:1', 'max:100']
        );
        $settings->add(
            Input::create('site-per-page')
                ->setType('number')
                ->setLabel('products::settings.attributes.site-per-page')
                ->setDefaultValue(Product::LIMIT_PER_PAGE_BY_DEFAULT)
                ->required(),
            ['required', 'integer', 'min:1', 'max:100']
        );

        $settings->add(
            Toggle::create('show-categories-if-has')
                ->setLabel('products::settings.attributes.show-categories-if-has')
                ->setDefaultValue(false)
                ->required(),
            ['required', 'boolean']
        );
        $settings->add(
            Toggle::create('show-brand-in-item-card')
                ->setLabel('products::settings.attributes.show-brand-in-item-card')
                ->setDefaultValue(true)
                ->required(),
            ['required', 'boolean']
        );
        $settings->add(
            Input::create('sizes_title')
                ->setLabel('products::settings.attributes.sizes_title'),
            [], 5001
        );
        $settings->add(
            TinyMce::create('sizes_text')
                ->setLabel('products::settings.attributes.sizes_text'),
            [], 5002
        );
        
        Widget::register(ProductInvoice::class, 'products::in-invoice');
        Widget::register(ProductGroupLiveSearchSelect::class, 'products::groups::live-search');
    }

    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        Widget::register(ProductsList::class, 'products::list');
        Widget::register(ProductGroupList::class, 'products::groups-list');
        Widget::register(ProductCard::class, 'products::card');
        Widget::register(ProductGroupCard::class, 'products::group-card');
        Widget::register(ProductControls::class, 'products::controls');
        Widget::register(ProductPrice::class, 'products::price');
        Widget::register(ProductsListCategoryPage::class, 'products::category-page');
        Widget::register(ProductsListBrandPage::class, 'products::brand-page');
        Widget::register(ProductsViewedPage::class, 'products::viewed-page');
        Widget::register(ProductFilter::class, 'products::filter');
        Widget::register(ProductFilterPrice::class, 'products::filter-price');
        Widget::register(ProductTabMain::class, 'products::tab-main');
        Widget::register(ProductTabDescription::class, 'products::tab-description');
        Widget::register(ProductTabFeatures::class, 'products::tab-features');
        Widget::register(ProductTabDescFeatures::class, 'products::tab-desc-features');
        Widget::register(ProductTabReviews::class, 'products::tab-reviews');
        Widget::register(ProductsWishlistPage::class, 'products::wishlist-page');
        Widget::register(SearchBar::class, 'products::search-bar');
        Widget::register(SortProductsBar::class, 'products::sort-bar');
        Widget::register(ProductFilterChosen::class, 'products::chosen-parameters-in-filter');
        Widget::register(ProductAmount::class, 'products::amount');
        Widget::register(ProductAmountOld::class, 'products::amount-old');
        Widget::register(ProductCartItem::class, 'products::cart-item');
        Widget::register(ProductInCheckout::class, 'products::checkout');
        Widget::register(ProductImage::class, 'products::image');
        Widget::register(ProductOrder::class, 'products::in-order');
        Widget::register(ProductPrintOrder::class, 'products::print-order');
        Widget::register(MobileButton::class, 'mobile-top-search-button');
        Widget::register(CompareProductsListAll::class, 'products::compare-page-all');
        Widget::register(CompareProductsList::class, 'products::compare-page');
        Widget::register(CompareProductCard::class, 'products::compare-card');
        Widget::register(ProductOrderMail::class, 'products::order-mail-item');
        Widget::register(ProductsSlider::class, 'products::slider');
        Widget::register(ProductGroupSlider::class, 'products::groups-slider');
        Widget::register(ProductDescription::class, 'products::description');
        Widget::register(ProductGroupDescription::class, 'products::group-description');
        Widget::register(MicroDataSearchBar::class, 'products::microdata-search');

        view()->share('searchBarMicrodataWidgetName', 'products::microdata-search');
    }


    /**
     * @return array
     */
    public function initSitemapXml()
    {
        $languages = config('languages', []);
        $default_language = null;
        /** @var Language $language */
        foreach ($languages as $language) {
            if ($language->default) {
                $default_language = $language->slug;
            }
        }

        $items = [];
        ProductTranslates::whereHas('row', function (Builder $builder) {
            $builder->where('active', true);
        })->get()->each(function (ProductTranslates $page) use (&$items, &$default_language) {
            $prefix = ($default_language === $page->language) ? '' : '/' . $page->language;
            $items[] = [
                'url' => url($prefix . route('site.product', ['slug' => $page->slug], false), [], isSecure()),
            ];
        });

        return $items;
    }
}
