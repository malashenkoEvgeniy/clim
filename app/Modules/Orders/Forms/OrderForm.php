<?php

namespace App\Modules\Orders\Forms;

use App\Components\Delivery\NovaPoshta;
use App\Core\Interfaces\FormInterface;
use App\Modules\Orders\Models\Order;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use CustomForm\Text;
use CustomForm\TextArea;
use Illuminate\Database\Eloquent\Model;
use Widget, Html;

/**
 * Class OrderForm
 *
 * @package App\Modules\Orders\Forms
 */
class OrderForm implements FormInterface
{

    /**
     * @param Model|null $order
     * @return Form
     * @throws \App\Exceptions\WrongParametersException|\Exception
     */
    public static function make(?Model $order = null): Form
    {
        $order = $order ?? new Order;
        $client = ($order && $order->exists) ? $order->client : null;
        $form = Form::create();
        $tabs = $form->tabs();

        if ($order && $order->exists) {
            if ($order->user_id) {
                $user = Text::create('user')
                    ->setDefaultValue(Widget::show('short-user-information', $order->user));
            } else {
                $user = Text::create('user')
                    ->setDefaultValue(
                        Html::tag(
                            'div',
                            trans('orders::general.no-user-selected'),
                            [
                                'class' => ['form-group', 'text-bold', 'text-red']
                            ]
                        )
                    );
            }
        } else {
            $user = Text::create('user')
                ->setDefaultValue(Widget::show('live-search-user'));
        }
    
        $novaPoshta = new NovaPoshta();
        $cities = [];
        foreach ($novaPoshta->getCities()->data as $city) {
            $cities[$city->Ref] = $city->DescriptionRu;
        }
        
        $tabs->createTab('Шаг 1. Контактная информация')->fieldSet()->add(
            $user,
            Input::create('name', $client)
                ->setLabel('validation.attributes.first_name')
                ->required(),
            Input::create('email', $client)
                ->setType('email')
                ->setOptions([(bool)config('db.orders.email-is-required', true) ? 'required' : 'nullable']),
            Input::create('phone', $client)->setDefaultValue('+380')->required(),
            Select::create('locationId')
                ->setLabel(trans('orders::general.sender-city'))
                ->setPlaceholder('&mdash;')
                ->addClasses('changeCity')
                ->setOptions(['href' => route('admin.warehouses.city'), 'insert-block' => '#senderWarehouses'])
                ->add($cities)
                ->setValue($order->city_ref)
                ->required()
        );
        $deliveries = array_keys(config('orders.deliveries', []));
        foreach ($deliveries as $key => $delivery) {
            unset($deliveries[$key]);
            $deliveries[$delivery] = "orders::general.deliveries.$delivery";
        }
        $paymentMethods = array_keys(config('orders.payment-methods', []));
        foreach ($paymentMethods as $key => $paymentMethod) {
            unset($paymentMethods[$key]);
            $paymentMethods[$paymentMethod] = "orders::general.payment-methods.$paymentMethod";
        }
        $other = [];
        foreach ((array)config('orders.rest-deliveries', []) as $deliveryType) {
            $other[$deliveryType] = $deliveryType;
        }
        $senderWarehouses = [];
        if ($order->city_ref || old('locationId')) {
            foreach ((array)$novaPoshta->getWarehousesCityRef($order->city_ref ?: old('locationId'))->data as $warehouse) {
                $senderWarehouses[$warehouse->Ref] = $warehouse->DescriptionRu;
            }
        }

        $tabs->createTab('Шаг 2. Доставка и оплата')->fieldSet()->add(
            Select::create('delivery', $order)
                ->addClasses('hidden-block-trigger')
                ->setLabel('orders::general.delivery-type')
                ->add($deliveries)
                ->required(),
            Input::create('nova-poshta')
                ->addClassesToDiv('hidden-block')
                ->addClassesToDiv(($order && $order->delivery === 'nova-poshta') ? 'show-hidden-block' : '')
                ->setValue($order->delivery_address)
                ->setLabel('orders::general.delivery-address')
                ->required(),
            Input::create('address')
                ->addClassesToDiv('hidden-block')
                ->addClassesToDiv(($order && $order->delivery === 'address') ? 'show-hidden-block' : '')
                ->setValue($order->delivery_address)
                ->setLabel('orders::general.delivery-address')
                ->required(),
            Select::create('nova-poshta-self')
                ->addClassesToDiv('hidden-block')
                ->addClassesToDiv(($order && $order->delivery === 'nova-poshta-self') ? 'show-hidden-block' : '')
                ->setLabel(trans('orders::general.sender-warehouse'))
                ->setOptions(['id' => 'senderWarehouses'])
                ->add($senderWarehouses)
                ->setValue($order->warehouse_ref)
                ->required(),
            Select::create('other')
                ->addClassesToDiv('hidden-block')
                ->addClassesToDiv(($order && $order->delivery === 'other') ? 'show-hidden-block' : '')
                ->setValue($order->delivery_address)
                ->setLabel('orders::general.payment-method')
                ->add($other)
                ->required(),
            Select::create('payment_method', $order)
                ->setLabel('orders::general.payment-method')
                ->add($paymentMethods)
                ->required(),
            ($order->exists && $order->paid_auto) ?
                Text::create()
                    ->setDefaultValue(
                        \Html::tag(
                            'div',
                            trans('orders::general.paid-auto'),
                            ['class' => ['form-group', 'text-red', 'text-bold']]
                        )
                    ) :
                Toggle::create('paid', $order)
                    ->setLabel('orders::general.paid')
                    ->setDefaultValue(false),
            TextArea::create('comment', $order)->setOptions(['rows' => 3]),
            Toggle::create('do_not_call_me', $order)
                ->setLabel('orders::general.do-not-call-me')
                ->setDefaultValue(true),
            Input::create('ttn', $order)
                ->setLabel('orders::general.ttn-number')
        );

        $tabs->createTab('Шаг 3. Товары')
            ->fieldSetForView(
                'orders::admin.orders.items.list',
                ['order' => $order]
            );
        return $form;
    }

}
