<?php

namespace App\Core\Modules\Security;

use App\Core\BaseProvider;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomSettings, CustomRoles;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Core\Modules\Security
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
        //CustomRoles::add('security', 'security::general.permission-name');
        // Additional settings list
        $this->basicAuth();
    }

    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot() {}

    /**
     * @throws \App\Exceptions\WrongParametersException
     */
    private function basicAuth()
    {
        // Register module configurable settings
        $settings = CustomSettings::createAndGet('basic-auth', 'security::basic-auth.settings-name',-9999);
        $settings->add(
            Toggle::create('auth')->setLabel('security::basic-auth.attributes.auth')
        );
        $settings->add(
            Input::create('username')->setLabel('security::basic-auth.attributes.username'),
            ['required_if:auth,1', 'nullable', 'string', 'min:1']
        );
        $settings->add(
            Input::create('password')->setLabel('security::basic-auth.attributes.password'),
            ['required_if:auth,1', 'nullable', 'string', 'min:1']
        );
    }


}
