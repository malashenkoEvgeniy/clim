<?php

namespace App\Modules\Features\Widgets\Admin;

use App\Components\Widget\AbstractWidget;
use App\Modules\Features\Models\Feature;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class FeaturesFormOnProductPage
 *
 * @package App\Modules\Features\Widgets
 */
class FeaturesOnProductPage implements AbstractWidget
{
    /**
     * @var array
     */
    protected $featuresAndValues;
    
    /**
     * @var int
     */
    protected $doNotShow;
    
    /**
     * FeaturesOnProductPage constructor.
     *
     * @param array $featuresAndValues
     * @param int|null $doNotShow
     */
    public function __construct(array $featuresAndValues = [], ?int $doNotShow = null)
    {
        $this->featuresAndValues = $featuresAndValues;
        $this->doNotShow = $doNotShow;
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        if (count($this->featuresAndValues)) {
            $featureIds = array_keys($this->featuresAndValues);
            $features = Feature::whereIn('id', $featureIds)
                ->with('current', 'values', 'values.current')
                ->oldest('position')
                ->get();
        } else {
            $features = new Collection();
        }
        return view('features::admin.widgets.product-page-list', [
            'features' => $features,
            'featuresAndValues' => $this->featuresAndValues,
            'doNotShow' => $this->doNotShow,
        ]);
    }
    
}
