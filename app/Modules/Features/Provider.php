<?php

namespace App\Modules\Features;

use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\RouteObjectValue;
use App\Core\BaseProvider;
use App\Modules\Features\Components\Feature;
use App\Modules\Features\Widgets\Admin\FeaturesFormOnProductPage;
use App\Modules\Features\Widgets\Admin\FeaturesOnProductPage;
use App\Modules\Features\Widgets\FeaturesForCompare;
use CustomForm\Macro\Toggle;
use CustomMenu, ProductsFilter, CustomRoles, Widget, Catalog;
use App\Modules\Features\Models\Feature as FeatureModel;
use App\Modules\Features\Models\FeatureValue as FeatureValueModel;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Features
 */
class Provider extends BaseProvider
{

    /**
     * Set custom presets
     */
    protected function presets()
    {
        Catalog::loadFeature(new Feature());
    }

    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        CustomMenu::get()->group()
            ->block('catalog')
            ->link('features::general.menu', RouteObjectValue::make('admin.features.index'))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.features.edit'),
                RouteObjectValue::make('admin.features.create'),
                RouteObjectValue::make('admin.features.destroy')
            );
        CustomRoles::add('features', 'features::general.permission-name')->except(RoleRule::VIEW);
    
        $settings = \CustomSettings::createAndGet('products');
        $settings->add(
            Toggle::create('show-main-features')
                ->setLabel('features::settings.attributes.show-main-features')
                ->setDefaultValue(false)
                ->required(),
            ['required', 'boolean']
        );

        $settings->add(
            Toggle::create('show-features-productpage')
                ->setLabel('features::settings.attributes.show-features-productpage')
                ->setDefaultValue(false)
                ->required(),
            ['required', 'boolean']
        );
    
        Widget::register(FeaturesFormOnProductPage::class, 'features::select-in-product');
        Widget::register(FeaturesOnProductPage::class, 'features::admin::product-page');
    }

    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        Widget::register(FeaturesForCompare::class, 'features::compare');
    }

}
