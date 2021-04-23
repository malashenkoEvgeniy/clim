<?php

namespace App\Modules\CompareProducts\Widgets;

use App\Components\Widget\AbstractWidget;
use CompareProducts;

/**
 * Class CompareProductButton
 *
 * @package App\Modules\CompareProducts\Widgets
 */
class CompareMobileButton implements AbstractWidget
{

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('compare::site.mobile-button', [
            'total' => CompareProducts::count(),
        ]);
    }

}
