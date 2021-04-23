<?php

namespace App\Modules\SlideshowSimple;

use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\SlideshowSimple\Widgets\Slider;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use CustomMenu, CustomSettings, CustomRoles, Widget;
use App\Core\BaseProvider;
use Illuminate\Validation\Rule;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Index
 */
class Provider extends BaseProvider
{
    
    /**
     * Set custom presets
     */
    protected function presets()
    {
        $this->setConfigNamespace('slider-simple');
    }
    
    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        
        // Register module configurable settings
        $settings = CustomSettings::createAndGet('slideshow_simple', 'slideshow_simple::settings.group-name');
        $settings->add(
            Toggle::create('autoplay')
                ->required()
                ->setLabel(__('slideshow_simple::settings.attributes.autoplay')),
            ['required', 'bool']
        );
        $settings->add(
            Input::create('timing')
                ->addClasses('integer')
                ->setType('number')
                ->setLabel(__('slideshow_simple::settings.attributes.timing')),
            ['required_if:autoplay,1', 'nullable', 'integer', 'min:1000']
        );
        $settings->add(
            Select::create('effect')
                ->add(config('slider-simple.effect', []))
                ->setLabel(__('slideshow_simple::settings.attributes.effect'))
                ->required(),
            ['required', Rule::in(array_keys(config('slider-simple.effect', [])))]
        );
        // Register left menu block
        CustomMenu::get()->group()
            ->link(
                'slideshow_simple::general.menu',
                RouteObjectValue::make('admin.slideshow_simple.index'),
                'fa fa-image'
            )
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.slideshow_simple.edit'),
                RouteObjectValue::make('admin.slideshow_simple.create')
            );
        // Register role scopes
        CustomRoles::add('slideshow_simple', 'slideshow_simple::general.menu')->except(RoleRule::VIEW);
    }
    
    protected function afterBoot()
    {
        Widget::register(Slider::class, 'slideshow');
    }
    
}
