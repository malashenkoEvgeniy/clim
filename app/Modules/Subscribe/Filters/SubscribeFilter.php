<?php

namespace App\Modules\Subscribe\Filters;

use Carbon\Carbon;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\DateRangePicker;
use CustomForm\Select;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
* Class SubcribeFilter
*
* @package App\Core\Modules\Subscribe\Filters
*/
class SubscribeFilter extends ModelFilter
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
            Input::create('name')->setValue(request('name'))->setLabel(__('subscribe::general.user-name'))
                ->addClassesToDiv('col-md-2'),
            Input::create('email')->setValue(request('email'))
                ->addClassesToDiv('col-md-2'),
            DateRangePicker::create('created_at')->setValue(request('created_at'))->addClassesToDiv('col-md-2'),
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
     * @param string $name
     * @return $this
     */
    public function name(string $name)
    {
        $name = Str::lower($name);
        return $this->where( function (Builder $query) use ($name) {
            return $query->whereRaw('LOWER(name) LIKE ?', ["%$name%"]);
        });
    }


    /**
     * @param string $email
     * @return $this
     */
    public function email(string $email)
    {
        $email = Str::lower($email);
        return $this->where(function (Builder $query) use ($email) {
            return $query->whereRaw('LOWER(email) LIKE ?', ["%$email%"]);
        });
    }

    /**
     * @param string $createdAt
     * @return $this
     */
    public function createdAt(string $createdAt)
    {
        $range = explode(' - ', $createdAt);
        $startDate = Carbon::parse($range[0])->startOfDay();
        $endDate = Carbon::parse($range[1])->endOfDay();
        return $this->where(
            function (Builder $query) use ($startDate, $endDate) {
                return $query->where('created_at', '>=', $startDate)
                    ->where('created_at', '<=', $endDate);
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
