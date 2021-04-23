<?php

namespace App\Modules\Comments\Filters;

use Carbon\Carbon;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\DateRangePicker;
use CustomForm\Select;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class AdminFilter
 *
 * @package App\Core\Modules\Administrators\Filters
 */
class CommentFilter extends ModelFilter
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
            Input::create('name')
                ->setLabel('validation.attributes.first_name')
                ->setValue(request('name'))
                ->addClassesToDiv('col-md-3'),
            Input::create('email')->setType('email')->setValue(request('email'))
                ->addClassesToDiv('col-md-3'),
            DateRangePicker::create('published_at')->setValue(request('published_at'))->addClassesToDiv('col-md-2'),
            Select::create('active')
                ->add(
                    [
                        '0' => 'Неактивный',
                        '1' => 'Активный',
                    ]
                )
                ->setValue(request('active'))
                ->addClassesToDiv('col-md-2')
                ->setPlaceholder('Все')
        );
        return $form->renderAsFilter();
    }
    
    /**
     * Filter by first_name
     *
     * @param  string $name
     * @return CommentFilter
     */
    public function name(string $name)
    {
        return $this->where(
            function (Builder $query) use ($name) {
                return $query->where('name', 'LIKE', "%$name%");
            }
        );
    }
    
    /**
     * Filter by email
     *
     * @param  string $email
     * @return CommentFilter
     */
    public function email(string $email)
    {
        return $this->where('email', 'LIKE', "$email%");
    }

    public function publishedAt(string $publishedAt)
    {
        $range = explode(' - ', $publishedAt);
        $startDate = Carbon::parse($range[0])->startOfDay();
        $endDate = Carbon::parse($range[1])->endOfDay();
        return $this->where(
            function (Builder $query) use ($startDate, $endDate) {
                return $query->where('published_at', '>=', $startDate)
                    ->where('published_at', '<=', $endDate);
            }
        );
    }

    /**
     * @param string $active
     * @return $this
     */
    public function active(string $active)
    {
        return $this->where(
            function (Builder $query) use ($active) {
                return $query->whereActive((bool)$active);
            }
        );
    }
}
