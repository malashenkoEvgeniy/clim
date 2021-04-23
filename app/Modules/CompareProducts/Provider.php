<?php

namespace App\Modules\CompareProducts;

use App\Core\BaseProvider;
use App\Core\ObjectValues\LinkObjectValue;
use App\Modules\CompareProducts\Facades\CompareFacade;
use App\Modules\CompareProducts\Widgets\CompareActionBarButton;
use App\Modules\CompareProducts\Widgets\CompareProductButton;
use App\Modules\CompareProducts\Widgets\CompareMobileButton;
use Illuminate\Foundation\AliasLoader;
use Widget, Catalog, CustomSiteMenu;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\CompareProducts
 */
class Provider extends BaseProvider
{

    /**
    * Set custom presets
    */
    protected function presets()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('CompareProducts', CompareFacade::class);
        
        $this->setModuleName('compare');
        $this->setTranslationsNamespace('compare');
        $this->setViewNamespace('compare');
        $this->setConfigNamespace('compare');
    }
    
    /**
     * Register widgets and menu for admin panel
     */
    protected function afterBootForAdminPanel()
    {
    }
    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        Widget::register(CompareActionBarButton::class, 'compare::action-bar');
        Widget::register(CompareProductButton::class, 'compare::button');
        Widget::register(CompareMobileButton::class, 'mobile-top-compare-button');
        
        // Register mobile menu block
        $menu = CustomSiteMenu::get('account-mobile');
        $menu->link(
            'compare::site.compare',
            LinkObjectValue::make(route('site.compare')),
            'icon-compare'
        );
    }

}
