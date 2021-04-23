<?php

namespace App\Modules\ProductsViewed;

use App\Core\BaseProvider;
use App\Modules\ProductsViewed\Widgets\ViewedProducts;
use CustomForm\Input;
use CustomSettings, Catalog, Widget;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\ProductsViewed
 */
class Provider extends BaseProvider
{

    /**
    * Set custom presets
    */
    protected function presets()
    {
        $this->setModuleName('viewed');
        $this->setTranslationsNamespace('viewed');
        $this->setViewNamespace('viewed');
        $this->setConfigNamespace('viewed');
    }
    
    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        // Register module configurable settings
        $settings = CustomSettings::createAndGet('viewed', 'viewed::general.settings-name');
        $settings->add(
            Input::create('per-page')
                ->setType('number')
                ->setLabel('viewed::settings.attributes.per-page')
                ->required(),
            ['required', 'integer', 'min:1']
        );
        $settings->add(
            Input::create('per-widget')
                ->setType('number')
                ->setLabel('viewed::settings.attributes.per-widget')
                ->required(),
            ['required', 'integer', 'min:1']
        );
    }
    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        Widget::register(ViewedProducts::class, 'viewed::products');
    }
    
}
