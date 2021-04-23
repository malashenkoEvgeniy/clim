<?php

namespace App\Modules\Reviews\Filters;

use App\Modules\Users\Models\User;
use Carbon\Carbon;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\DateRangePicker;
use CustomForm\Select;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
* Class ReviewsFilter
*
* @package App\Core\Modules\Reviews\Filters
*/
class ReviewsFilter extends ModelFilter
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
        $usersForSelect = [];

        $users = User::query()
            ->select()
            ->join('reviews', function ($join) {
                $join->on('reviews.user_id', '=', 'users.id');
            })
            ->get()
            ->keyBy('id')->map(function(User $user) use ($usersForSelect){
                return $user->first_name.' '. $user->last_name;
            })->toArray();

        $form->fieldSetForFilter()->add(
            Input::create('name')->setValue(request('name'))
                ->addClassesToDiv('col-md-2'),
            Input::create('email')->setValue(request('email'))
                ->addClassesToDiv('col-md-2'),
            Select::create('user')->add($users)
                ->setValue(request('user'))
                ->addClassesToDiv('col-md-2')
                ->setPlaceholder('Все'),
            DateRangePicker::create('published_at')
                ->setValue(request('published_at'))
                ->addClassesToDiv('col-md-2'),
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
        return $this->where( function (Builder $query) use ($email) {
            return $query->whereRaw('LOWER(email) LIKE ?', ["%$email%"]);
        });
    }

    /**
     * @param string $user
     * @return $this
     */
    public function user(string $user)
    {
        return $this->where( function (Builder $query) use ($user) {
            return $query->where('user_id', '=', $user);
        });
    }

    /**
     * @param string $publishedAt
     * @return $this
     */
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
