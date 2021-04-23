<?php

namespace App\Core\Modules\Images;

use App\Core\BaseProvider;
use App\Core\Modules\Administrators\Models\RoleRule;
use CustomRoles;

/**
 * Class Provider
 * Settings service provider
 *
 * @package App\Core\Modules\Settings
 */
class Provider extends BaseProvider
{
    protected function presets()
    {
    }
    
    protected function afterBootForAdminPanel()
    {
        // Register role scopes
        CustomRoles::add('crop', 'images::general.crop-name')
            ->only(RoleRule::INDEX, RoleRule::UPDATE);
        CustomRoles::add('images', 'images::general.images-name')
            ->only( RoleRule::UPDATE);
    }
    
}
