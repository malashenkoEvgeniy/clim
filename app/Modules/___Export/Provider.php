<?php

namespace App\Modules\Export;

use App\Core\BaseProvider;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Export
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
    }
    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {

    }

}
