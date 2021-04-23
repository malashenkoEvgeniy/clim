<?php

namespace App\Modules\FastOrders\Filters;

use Carbon\Carbon;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\DateRangePicker;
use CustomForm\Select;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FastOrdersFilter
 *
 * @package App\Core\Modules\FastOrders\Filters
 */
class FastOrdersFilter extends ModelFilter
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
            Input::create('ip')->setValue(request('ip'))
                ->addClassesToDiv('col-md-2'),
            Input::create('phone')->setValue(request('phone'))
                ->addClassesToDiv('col-md-2'),
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
     * Filter by $ip
     *
     * @param  string $ip
     * @return FastOrdersFilter
     */
    public function ip(string $ip)
    {
        return $this->where(
            function (Builder $query) use ($ip) {
                return $query->where('ip', 'LIKE', "%$ip%");
            }
        );
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
