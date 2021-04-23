<?php

namespace App\Modules\Import\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Currencies\Components\CurrencyRates\Rate;

/**
 * Class CoursesHistory
 *
 * @package App\Modules\Import\Widgets
 */
class CoursesHistory implements AbstractWidget
{
    /**
     * @var array
     */
    private $courses;
    
    /**
     * @var string
     */
    private $currency;
    
    /**
     * CoursesHistory constructor.
     *
     * @param string $defaultCurrency
     * @param array $courses
     */
    public function __construct(string $defaultCurrency, array $courses = [])
    {
        $this->courses = $courses;
        $this->currency = $defaultCurrency;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('import::admin.courses-history', [
            'nbu' => Rate::aggregator(Rate::AGGREGATOR_NBU),
            'personal' => Rate::aggregator(),
            'mainCurrencyCode' => Rate::instance()->getMainCurrencyCode(),
            'courses' => $this->courses,
        ]);
    }
    
}
