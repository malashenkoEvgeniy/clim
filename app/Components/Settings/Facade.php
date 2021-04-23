<?php

namespace App\Components\Settings;

/**
 * Class Facade
 * This is facade class for SettingsContainer
 *
 * @package App\Components\Settings
 */
class Facade extends \Illuminate\Support\Facades\Facade
{
    
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor(): string
    {
        return SettingsContainer::class;
    }
    
}
