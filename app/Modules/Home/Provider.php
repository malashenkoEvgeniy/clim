<?php

namespace App\Modules\Home;

use App\Core\BaseProvider;
use App\Core\Modules\SystemPages\Models\SystemPage;
use App\Core\ObjectValues\RouteObjectValue;
use CustomForm\Input;
use CustomForm\TextArea;
use CustomForm\TinyMce;
use Seo, CustomSettings;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Home
 */
class Provider extends BaseProvider
{
    /**
     * @var SystemPage
     */
    static $page;

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
        $settings = CustomSettings::createAndGet('basic', 'home::basic.settings-name', -9999);
        $settings->add(
            Input::create('site_email')
                ->setLabel('home::basic.attributes.site-email')
        );
        $settings->add(
            Input::create('hot_line')
                ->setLabel('home::basic.attributes.hot-line')
        );
        $settings->add(
            Input::create('phone_number_1')
                ->setLabel('home::basic.attributes.phone-number')
        );
        $settings->add(
            Input::create('phone_number_2')
                ->setLabel('home::basic.attributes.phone-number')
        );
        $settings->add(
            Input::create('phone_number_3')
                ->setLabel('home::basic.attributes.phone-number')
        );
        $settings->add(
            TextArea::create('schedule')->setLabel('home::basic.attributes.schedule')
        );
        $settings->add(
            Input::create('company')
                ->setLabel('home::basic.attributes.company')
        );
        $settings->add(
            Input::create('copyright')
                ->setLabel('home::basic.attributes.copyright')
        );
        $settings->add(
            Input::create('agreement_link')
                ->setLabel('home::basic.attributes.agreement_link')
        );
        $settings->add(
            Input::create('cache_life_time')->setType('number')
                ->setLabel('home::basic.attributes.cache_life_time')
        );
    }
    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        if (\Schema::hasTable((new SystemPage)->getTable())) {
            static::$page = SystemPage::getByCurrent('slug', 'index');
            if (static::$page) {
                $this->app->booted(function () {
                    Seo::breadcrumbs()->add(static::$page->current->name, RouteObjectValue::make('site.home'));
                });
            }
        }
 }

}
