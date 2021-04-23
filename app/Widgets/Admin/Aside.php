<?php

namespace App\Widgets\Admin;

use CustomMenu;
use App\Components\Widget\AbstractWidget;

/**
 * Class Aside
 * Left menu for admin panel
 *
 * @package App\Widgets\Admin
 */
class Aside implements AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    final public function render()
    {
        return view(
            'admin.widgets.aside', [
                'menu' => CustomMenu::get()->groups(),
            ]
        );
    }
    
}
