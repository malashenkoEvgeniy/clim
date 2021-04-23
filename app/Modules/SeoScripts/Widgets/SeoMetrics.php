<?php

namespace App\Modules\SeoScripts\Widgets;


use App\Components\Widget\AbstractWidget;
use App\Modules\SeoScripts\Models\SeoScript;

class SeoMetrics implements AbstractWidget
{
    /**
     * @var string
     */
    protected $place;

    /**
     * SeoMetrics constructor.
     * @param $place
     */
    public function __construct($place)
    {
        $this->place = $place;
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $items = SeoScript::whereActive(1)->wherePlace($this->place)->get();
        if (!$items || !$items->count()) {
            return null;
        }


        return view('seo_scripts::site.metrics', [
            'items' => $items,
        ]);
    }
}