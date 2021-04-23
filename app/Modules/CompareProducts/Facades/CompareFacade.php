<?php

namespace App\Modules\CompareProducts\Facades;

use Illuminate\Support\Facades\Facade as BaseFacade;

class CompareFacade extends BaseFacade
{
    
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Compare::class;
    }
}
