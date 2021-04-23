<?php

namespace App\Modules\Import\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Currencies\Components\CurrencyRates\Rate;

/**
 * Class Courses
 *
 * @package App\Modules\Import\Widgets
 */
class Courses implements AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('import::admin.courses', [
            'nbu' => Rate::aggregator(Rate::AGGREGATOR_NBU),
            'personal' => Rate::aggregator(),
            'mainCurrencyCode' => Rate::instance()->getMainCurrencyCode(),
        ]);
    }
}
