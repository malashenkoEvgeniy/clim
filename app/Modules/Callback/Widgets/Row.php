<?php

namespace App\Modules\Callback\Widgets;

use App\Components\Widget\AbstractWidget;

/**
 * Class Row
 *
 * @package App\Modules\Callback\Widgets
 */
class Row implements AbstractWidget
{

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('callback::site.row');
    }

}
