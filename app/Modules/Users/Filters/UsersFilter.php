<?php

namespace App\Modules\users\Filters;

use Carbon\Carbon;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\DateRangePicker;
use CustomForm\Select;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
* Class UsersFilter
*
* @package App\Core\Modules\users\Filters
*/
class UsersFilter extends ModelFilter
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    static function showFilter()
    {
        $form = Form::create();

        $form->fieldSetForFilter()->add(
            Input::create('name')->setValue(request('name'))
                ->addClassesToDiv('col-md-2'),
            Input::create('phone')->setValue(request('phone'))
                ->addClassesToDiv('col-md-2'),
            Input::create('email')->setValue(request('email'))
                ->addClassesToDiv('col-md-2'),
            DateRangePicker::create('created_at')->setValue(request('created_at'))->addClassesToDiv('col-md-2'),
            Select::create('active')
                ->add(
                    [
                        '0' => 'Неактивные',
                        '1' => 'Активные',
                    ]
                )
                ->setValue(request('active'))
                ->addClassesToDiv('col-md-2')
                ->setPlaceholder('Все')
        );
        return $form->renderAsFilter();
    }
    
    /**
     * Method for live search
     *
     * @param string $query
     * @return $this
     */
    public function query(string $query)
    {
        $intQuery = (int)$query;
        $query = Str::lower($query);
        return $this
            ->where('id', $intQuery)
            ->orWhereRaw('LOWER(first_name) LIKE ? or LOWER(last_name) LIKE ?', ["$query%", "$query%"])
            ->orWhereRaw('LOWER(email) LIKE ?', ["%$query%"])
            ->orWhereRaw('LOWER(phone) LIKE ?', ["%$query%"]);
    }
    
    /**
     * @param int $id
     * @return $this
     */
    public function id(int $id)
    {
        return $this->where('id', $id);
    }
    
    /**
     * @param string $name
     * @return $this
     */
    public function name(string $name)
    {
        $name = Str::lower($name);
        return $this->where(function (Builder $query) use ($name) {
            return $query
                ->whereRaw('LOWER(first_name) LIKE ?', ["%$name%"])
                ->orWhereRaw('LOWER(last_name) LIKE ?', ["%$name%"]);
        });
    }

    /**
     * @param string $phone
     * @return $this
     */
    public function phone(string $phone)
    {
        return $this->where('phone', 'LIKE', "%$phone%");
    }

    /**
     * @param string $email
     * @return $this
     */
    public function email(string $email)
    {
        return $this->whereRaw('LOWER(email) LIKE ?', ["%$email%"]);
    }

    /**
     * @param string $active
     * @return $this
     */
    public function active(string $active)
    {
        return $this->where('active', (bool)$active);
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
}
