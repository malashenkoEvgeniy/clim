<?php

namespace App\Modules\SocialButtons;

use App\Modules\SocialButtons\Widgets\SocialIcons;
use App\Modules\SocialButtons\Widgets\SocialIconsMobile;
use App\Core\BaseProvider;
use CustomForm\Input;
use CustomSettings, Widget;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\SocialButtons
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
        $settings = CustomSettings::createAndGet('social', 'social_buttons::general.settings-block-name');
        foreach (config('social_buttons.socials') as $key) {
            $settings->add(
                Input::create($key)->setLabel('social_buttons::general.icon-labels.' . $key)
            );
        }
        $settings->add(
            Input::create('addthis')->setLabel('social_buttons::general.addthis')
        );
    }

    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        Widget::register(SocialIcons::class, 'social_buttons::icons');
        Widget::register(SocialIconsMobile::class, 'social_buttons::icons-mobile');
    }

}
