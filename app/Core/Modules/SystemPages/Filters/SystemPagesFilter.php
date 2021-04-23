<?php

namespace App\Core\Modules\SystemPages\Filters;

use CustomForm\Builder\Form;
use CustomForm\Input;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
* Class SystemPagesFilter
*
* @package App\Core\Modules\SystemPages\Filters
*/
class SystemPagesFilter extends ModelFilter
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
            Input::create('slug')->setValue(request('slug'))
                ->addClassesToDiv('col-md-3')
        );
        return $form->renderAsFilter();
    }

    /**
     * @param string $name
     * @return $this
     */
    public function name(string $name)
    {
        $name = Str::lower($name);
        return $this->related('current', function (Builder $query) use ($name) {
            return $query->whereRaw('LOWER(name) LIKE ?', ["%$name%"]);
        });
    }

    /**
     * @param string $slug
     * @return $this
     */
    public function slug(string $slug)
    {
        $slug = Str::lower($slug);
        return $this->related('current', function (Builder $query) use ($slug) {
            return $query->whereRaw('LOWER(slug) LIKE ?', ["%$slug%"]);
        });
    }
}
