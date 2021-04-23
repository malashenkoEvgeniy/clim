<?php

namespace App\Modules\Orders\Filters;

use App\Components\Form\ObjectValues\ModelForSelect;
use App\Modules\Orders\Models\OrderStatus;
use Carbon\Carbon;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\DateRangePicker;
use CustomForm\Select;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class OrdersFilter
 *
 * @package App\Core\Modules\Orders\Filters
 */
class OrdersFilter extends ModelFilter
{
    /**
     * Generate form view
     *
     * @return string
     */
    static function showFilter()
    {
        $form = Form::create();
        $form->fieldSetForFilter()->add(
            Input::create('email')->setValue(request('email'))
                ->addClassesToDiv('col-md-2'),
            Input::create('phone')->setValue(request('phone'))
                ->addClassesToDiv('col-md-2'),
            DateRangePicker::create('created_at')
                ->setValue(request('created_at'))
                ->addClassesToDiv('col-md-2'),
            Select::create('order_status')
                ->setLabel(trans('orders::general.order-status'))
                ->model(ModelForSelect::make(OrderStatus::getList())->setValueFieldName('current.name'))
                ->setValue(request('order_status'))
                ->addClassesToDiv('col-md-2')
                ->setPlaceholder(__('global.all')),
            Select::create('payment_status')
                ->add([
                    '0' => trans('orders::general.not-paid'),
                    '1' => trans('orders::general.paid'),
                ])
                ->setValue(request('payment_status'))
                ->setLabel('orders::general.payment-status')
                ->addClassesToDiv('col-md-2')
                ->setPlaceholder(__('global.all'))
        );
        return $form->renderAsFilter();
    }

    /**
     * @param string $phone
     * @return $this
     */
    public function phone(string $phone)
    {
        return $this->related('client', function(Builder $query) use ($phone) {
            return $query->where('phone', 'LIKE', "%$phone%");
        });
    }

    /**
     * @param string $email
     * @return $this
     */
    public function email(string $email)
    {
        return $this->related('client', function(Builder $query) use ($email) {
            return $query->where('email', 'LIKE', "%$email%");
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
     * @param string $orderStatus
     * @return $this
     */
    public function orderStatus(string $orderStatus)
    {
        return $this->related('status', function(Builder $query) use ($orderStatus) {
            return $query->whereId($orderStatus);
        });
    }

    /**
     * @param string $paymentStatus
     * @return OrdersFilter
     */
    public function paymentStatus(string $paymentStatus)
    {
        return $this->where(
            function (Builder $query) use ($paymentStatus) {
                return $query->wherePaid($paymentStatus);
            }
        );
    }
}
