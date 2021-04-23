<?php

namespace App\Modules\Brands\Widgets\Admin;

use App\Components\Form\ObjectValues\ModelForSelect;
use App\Components\Widget\AbstractWidget;
use App\Modules\Brands\Models\Brand;
use CustomForm\Select;

/**
 * Class BrandsSelect
 *
 * @package App\Modules\Brands\Widgets
 */
class BrandsSelect implements AbstractWidget
{
    
    protected $selected;
    protected $width;
    
    /**
     * CategoriesSelect constructor.
     *
     * @param null|int $selected
     * @param int $width
     */
    public function __construct(?int $selected = null, int $width = 12)
    {
        $this->selected = $selected;
        $this->width = $width;
    }
    
    /**
     * @return \CustomForm\Select
     * @throws \App\Exceptions\WrongParametersException
     */
    public function render()
    {
        $parametersForSelect = ModelForSelect::make(
            Brand::with('current')->get()
        )->setValueFieldName('current.name');
        return Select::create('brand_id')
            ->addClassesToDiv('col-md-' . $this->width)
            ->model($parametersForSelect)
            ->setPlaceholder('&mdash;')
            ->setValue(old('brand_id', $this->selected));
    }
    
}
