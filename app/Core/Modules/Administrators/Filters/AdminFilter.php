<?php

namespace App\Core\Modules\Administrators\Filters;

use CustomForm\Builder\Form;
use CustomForm\Input;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Class AdminFilter
 *
 * @package App\Core\Modules\Administrators\Filters
 */
class AdminFilter extends ModelFilter
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
            Input::create('first_name')->setValue(request('first_name'))
                ->addClassesToDiv('col-md-3'),
            Input::create('email')->setType('email')->setValue(request('email'))
                ->addClassesToDiv('col-md-3')
        );
        return $form->renderAsFilter();
    }
    
    /**
     * Filter by first_name
     *
     * @param  string $name
     * @return AdminFilter
     */
    public function firstName(string $name)
    {
        $name = Str::lower($name);
        return $this->where(function (Builder $query) use ($name) {
            return $query->whereRaw('LOWER(first_name) LIKE ?', ["%$name%"]);
        });
    }
    
    /**
     * Filter by email
     *
     * @param  string $email
     * @return AdminFilter
     */
    public function email(string $email)
    {
        $email = Str::lower($email);
        return $this->whereRaw('LOWER(email) LIKE ?', ["$email%"]);
    }
}
