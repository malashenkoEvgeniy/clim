<?php

namespace App\Modules\Features\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Features\Models\Feature;
use Html;

/**
 * Class FeaturesForCompare
 *
 * @package App\Modules\Features\Widgets
 */
class FeaturesForCompare implements AbstractWidget
{
    
    /**
     * @var array
     */
    protected $featuresAndValues;
    
    /**
     * FeaturesOnProductPage constructor.
     *
     * @param array $featuresAndValues
     */
    public function __construct(array $featuresAndValues = [])
    {
        $this->featuresAndValues = $featuresAndValues;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (!$this->featuresAndValues) {
            return [];
        }
        $features = [];
        Feature::whereIn('id', array_keys($this->featuresAndValues))
            ->active(true)
            ->oldest('position')
            ->get()
            ->each(function (Feature $feature) use (&$features) {
                foreach ($feature->values as $value) {
                    if ($value->active === false) {
                        continue;
                    }
                    if (in_array($value->id, $this->featuresAndValues[$feature->id]) === false) {
                        continue;
                    }
                    $features[$feature->current->name] = $features[$feature->current->name] ?? [];
                    $features[$feature->current->name][] = $value->current->name;
                }
            });
        if (empty($features)) {
            return [];
        }
        return $features;
    }
    
}
