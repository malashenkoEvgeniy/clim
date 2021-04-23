<?php

namespace App\Modules\Brands\Filters;

use CustomForm\Builder\Form;
use CustomForm\Select;
use CustomForm\Input;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Class BrandsFilter
 *
 * @package App\Core\Modules\Brands\Filters
 */
class BrandsFilter extends ModelFilter
{
    /**
     * Generate form view
     *
     * @return string
     * @throws \App\Exceptions\WrongParametersException
     */
    static function showFilter()
    {
        $form = Form::create();
        $form->fieldSetForFilter()->add(
            Input::create('name')->setValue(request('name'))
                ->addClassesToDiv('col-md-3'),
            Select::create('active')
                ->add([
                    '0' => __('global.unpublished'),
                    '1' => __('global.published'),
                ])
                ->setValue(request('active'))
                ->addClassesToDiv('col-md-2')
                ->setPlaceholder(__('global.all'))
        );
        return $form->renderAsFilter();
    }

    /**
     * Filter by name
     *
     * @param  string $name
     * @return BrandsFilter
     */
    public function name(string $name)
    {
        $name = Str::lower($name);
        return $this->related('current', function (Builder $query) use ($name) {
            return $query->whereRaw('LOWER(name) LIKE ?', ["%$name%"]);
        });
    }

    /**
     * Filter by active
     *
     * @param  string $active
     * @return BrandsFilter
     */
    public function active(string $active)
    {
        return $this->where(function (Builder $query) use ($active) {
            return $query->whereActive((bool)$active);
        });
    }
}
