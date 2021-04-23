<?php

namespace App\Modules\SeoLinks\Filters;

use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Select;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Class SeoLinksFilter
 *
 * @package App\Modules\SeoLinks\Filters
 */
class SeoLinksFilter extends ModelFilter
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
            Input::create('url')->setValue(request('url'))
                ->addClassesToDiv('col-md-3'),
            Select::create('active')
                ->add([
                    0 => __('global.unpublished'),
                    1 => __('global.published'),
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
     * @return SeoLinksFilter
     */
    public function name(string $name)
    {
        $name = Str::lower($name);
        return $this->related('current', function(Builder $query) use ($name) {
            return $query->whereRaw('LOWER(name) LIKE ?', ["%$name%"]);
        });
    }

    /**
     * Filter by link
     *
     * @param  string $url
     * @return SeoLinksFilter
     */
    public function url(string $url)
    {
        return $this->where(function (Builder $query) use ($url) {
            return $query->whereUrl((string)$url);
        });
    }

    /**
     * Filter by active
     *
     * @param  string $active
     * @return SeoLinksFilter
     */
    public function active(string $active)
    {
        return $this->where(function (Builder $query) use ($active) {
            return $query->whereActive((bool)$active);
        });
    }
}
