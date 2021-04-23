<?php

namespace App\Modules\Features\Widgets\Admin;

use App\Components\Form\ObjectValues\ModelForSelect;
use App\Components\Widget\AbstractWidget;
use App\Modules\Features\Models\Feature;
use CustomForm\Select;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class FeaturesFormOnProductPage
 *
 * @package App\Modules\Features\Widgets
 */
class FeaturesFormOnProductPage implements AbstractWidget
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
     * @return \CustomForm\Select
     * @throws \App\Exceptions\WrongParametersException
     */
    public function render()
    {
        $featuresSelect = Select::create('group_feature_id')
            ->model(
                ModelForSelect::make(
                    Feature::with('current')->whereNotIn('id', (array)$this->doNotShow)->get()
                )->setValueFieldName('current.name')
            )
            ->setLabel('features::general.feature')
            ->addClassesToDiv('col-md-5')
            ->setOptions(['id' => 'feature-select'])
            ->setPlaceholder('&mdash;');
        
        return view('features::admin.widgets.product-page', [
            'featuresSelect' => $featuresSelect,
            'valuesSelect' => Select::create('group_feature_value_id')
                ->setLabel('features::general.values')
                ->setOptions(['id' => 'feature-value-select', 'disabled'])
                ->addClassesToDiv('col-md-4')
                ->setPlaceholder('&mdash;'),
            'featuresAndValues' => $this->featuresAndValues,
            'doNotShow' => $this->doNotShow,
        ]);
    }
    
}
