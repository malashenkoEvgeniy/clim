<?php

namespace App\Modules\Callback\Filters;

use Carbon\Carbon;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\DateRangePicker;
use CustomForm\Select;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

/**
 * Class CallbackFilter
 *
 * @package App\Core\Modules\Callback\Filters
 */
class CallbackFilter extends ModelFilter
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
            Input::create('phone')->setValue(request('phone'))
                ->addClassesToDiv('col-md-3'),
            DateRangePicker::create('created_at')
                ->setValue(request('created_at'))
                ->addClassesToDiv('col-md-2'),
            Select::create('active')
                ->add([
                    '0' => __('global.unprocessed'),
                    '1' => __('global.processed'),
                ])
                ->setValue(request('active'))
                ->addClassesToDiv('col-md-2')
                ->setPlaceholder('Все')
        );
        return $form->renderAsFilter();
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
     * @param string $name
     * @return $this
     */
    public function name(string $name)
    {
        $name = Str::lower($name);
        return $this->where(function (Builder $query) use ($name) {
            return $query->whereRaw('LOWER(name) LIKE ?', ["%$name%"]);
        });
    }

    /**
     * @param string $phone
     * @return $this
     */
    public function phone(string $phone)
    {
        return $this->where(
            function (Builder $query) use ($phone) {
                return $query->where('phone', 'LIKE', "%$phone%");
            }
        );
    }

    /**
     * @param string $blockedForever
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
