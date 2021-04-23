<?php

namespace App\Core\Modules\Notifications\Filters;

use Carbon\Carbon;
use CustomForm\Builder\Form;
use CustomForm\Macro\DateRangePicker;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class NotificationsFilter
 *
 * @package App\Core\Modules\Notifications\Filters
 */
class NotificationsFilter extends ModelFilter
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
            DateRangePicker::create('created_at')
                ->setValue(request('created_at'))
                ->addClassesToDiv('col-md-4')
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

}
