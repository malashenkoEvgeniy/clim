<?php

namespace App\Modules\Brands;

use App\Core\BaseProvider;
use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\Modules\Languages\Models\Language;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Brands\Components\Brand;
use App\Modules\Brands\Models\BrandTranslates;
use App\Modules\Brands\Widgets\Admin\BrandWithLinkInAdminPanel;
use App\Modules\Brands\Widgets\OurBrands;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomSettings, CustomRoles, CustomMenu, Widget, Catalog, ProductsFilter;
use App\Modules\Brands\Models\BrandTranslates as BrandTranslatesModel;
use App\Modules\Brands\Models\Brand as BrandModel;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Brands
 */
class Provider extends BaseProvider
{

    /**
    * Set custom presets
    */
    protected function presets()
    {
        Catalog::loadBrands(new Brand());
    }
    
    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        // Register module configurable settings
        $settings = CustomSettings::createAndGet('brands', 'brands::general.settings-name');
        $settings->add(
            Input::create('per-page')
                ->setType('number')
                ->setDefaultValue(BrandModel::DEFAULT_LIMIT_IN_ADMIN_PANEL)
                ->setLabel('brands::settings.attributes.per-page')
                ->required(),
            ['required', 'integer', 'min:1']
        );
        $settings->add(
            Toggle::create('show-our-brands-widget')
                ->setDefaultValue(true)
                ->setLabel('brands::settings.attributes.show-our-brands-widget')
                ->required(),
            ['required', 'boolean']
        );
        // Register role scopes
        CustomRoles::add('brands', 'brands::general.permission-name')
            ->except(RoleRule::VIEW);
        // Register left menu block
        CustomMenu::get()->group()
            ->block('catalog')
            ->link('brands::general.menu', RouteObjectValue::make('admin.brands.index'))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.brands.edit'),
                RouteObjectValue::make('admin.brands.create')
            );
        
        Widget::register(BrandWithLinkInAdminPanel::class, 'brands::admin-panel::with-link');
    }
    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot() {
        Widget::register(OurBrands::class, 'brands::our-brands');
    }
    
    /**
     * Links data to filter
     */
    public static function filter(): void
    {
        if (ProductsFilter::hasBlock('brand')) {
            return;
        }
        $block = ProductsFilter::addBlock('brands::site.brand', 'brand', true)
            ->setId('brand');
        BrandTranslatesModel::allActiveForFilter()->each(function (BrandTranslatesModel $brand) use ($block) {
            $block
                ->addElement($brand->name, $brand->slug)
                ->setId($brand->row_id);
        });
    }

    public function initSitemap()
    {
        $items = [];
        BrandModel::with('current')->active()->latest('id')->get()->each(function (BrandModel $brand) use (&$items) {
            $items[] = [
                'name' => $brand->current->name,
                'url' => $brand->link,
            ];
        });
        return [[
            'name' => __('brands::site.our-brands'),
            'items' => $items,
        ]];
    }


    public function initSitemapXml()
    {
        $languages = config('languages', []);
        $default_language = null;
        /** @var Language $language */
        foreach($languages as $language){
            if($language->default){
                $default_language = $language->slug;
            }
        }
        $items = [];
        BrandTranslates::whereHas('row', function (Builder $builder){
            $builder->where('active', true);
        })->get()->each(function (BrandTranslates $page) use (&$items, &$default_language) {
            $prefix = ($default_language === $page->language) ? '' : '/' . $page->language;
            $items[] = [
                'url' => url($prefix . route('site.brands.show', [$page->slug], false), [], isSecure())
            ];
        });
        return $items;
    }

}
