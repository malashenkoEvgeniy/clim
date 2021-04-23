<?php

namespace App\Modules\CompareProducts\Widgets;

use App\Components\Widget\AbstractWidget;
use CompareProducts;

/**
 * Class CompareActionBarButton
 *
 * @package App\Modules\CompareProducts\Widgets
 */
class CompareActionBarButton implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('compare::site.action-bar', [
            'total' => CompareProducts::count(),
        ]);
    }
    
}
