<?php

namespace App\Modules\ProductsAvailability\Filters;

use Carbon\Carbon;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\DateRangePicker;
use CustomForm\Select;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ProductsAvailabilityFilter
 *
 * @package App\Core\Modules\ProductsAvailability\Filters
 */
class ProductsAvailabilityFilter extends ModelFilter
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
            Input::create('email')->setValue(request('email'))
                ->addClassesToDiv('col-md-2'),
            DateRangePicker::create('created_at')
                ->setValue(request('created_at'))
                ->addClassesToDiv('col-md-2')
        );
        return $form->renderAsFilter();
    }

    /**
     * @param string $email
     * @return $this
     */
    public function email(string $email)
    {
        return $this->where(
            function (Builder $query) use ($email) {
                return $query->where('email', 'LIKE', "%$email%");
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
}
