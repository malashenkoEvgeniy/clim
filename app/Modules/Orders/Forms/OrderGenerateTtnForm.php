<?php

namespace App\Modules\Orders\Forms;

use App\Components\Delivery\NovaPoshta;
use App\Core\Interfaces\FormInterface;
use App\Modules\Orders\Models\Order;
use Carbon\Carbon;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\DateTimePicker;
use CustomForm\Select;
use CustomForm\Submit;
use Illuminate\Database\Eloquent\Model;
use NovaPoshta\ApiModels\Common;

/**
 * Class OrderForm
 *
 * @package App\Modules\Orders\Forms
 */
class OrderGenerateTtnForm implements FormInterface
{

    /**
     * @param Model|Order|null $order
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $order = null): Form
    {
        $order = $order ?? new Order;
        $form = Form::create();
        $client = ($order && $order->exists) ? $order->client : null;
        $novaPoshta = new NovaPoshta();
        $cities = [];
        foreach ($novaPoshta->getCities()->data as $city) {
            $cities[$city->Ref] = $city->DescriptionRu;
        }
        $senderWarehouses = [];
        if (config('db.nova-poshta.sender-warehouse')) {
            foreach ($novaPoshta->getWarehousesCityRef(config('db.nova-poshta.sender-city'))->data as $warehouse) {
                $senderWarehouses[$warehouse->Ref] = $warehouse->DescriptionRu;
            }
        }
        //Sender
        $fieldSetSender = $form->fieldSet(6, FieldSet::COLOR_SUCCESS, trans('orders::general.sender'));
        $fieldSetSender->add(
            Input::create('senderLastName')->setValue(config('db.nova-poshta.sender-last-name'))
                ->setLabel(trans('orders::general.sender-last-name'))
                ->required(),
            Input::create('senderFirstName')->setValue(config('db.nova-poshta.sender-first-name'))
                ->setLabel(trans('orders::general.sender-first-name'))
                ->required(),
            Input::create('senderMiddleLame')->setValue(config('db.nova-poshta.sender-middle-name'))
                ->setLabel(trans('orders::general.sender-middle-name'))
                ->required(),
            Input::create('senderPhone')->setValue(config('db.nova-poshta.sender-phone'))
                ->setLabel(trans('orders::general.sender-phone'))
                ->required(),
            Select::create('senderCity')
                ->setLabel(trans('orders::general.sender-city'))
                ->addClasses('changeCity')
                ->setOptions(['href' => route('admin.warehouses.city'), 'insert-block' => '#senderWarehouses'])
                ->add($cities)
                ->setValue(config('db.nova-poshta.sender-city'))
                ->required(),
            Select::create('senderWarehouses')
                ->setLabel(trans('orders::general.sender-warehouse'))
                ->setOptions(['id' => 'senderWarehouses'])
                ->add($senderWarehouses)
                ->setValue(config('db.nova-poshta.sender-warehouse'))
                ->required()
        );
        //Recipient
        $recipientWarehouses = [];
        if ($order->warehouse_ref) {
            foreach ($novaPoshta->getWarehousesCityRef($order->city_ref)->data as $warehouse) {
                $recipientWarehouses[$warehouse->Ref] = $warehouse->DescriptionRu;
            }
        }
        $fieldSetRecipient = $form->fieldSet(6, FieldSet::COLOR_SUCCESS, trans('orders::general.recipient'));
        $clientFIO = explode(' ', $client->name);
        $fieldSetRecipient->add(
            Input::create('recipientLastName')->setValue(array_get($clientFIO, 0))
                ->setLabel(trans('orders::general.recipient-last-name'))
                ->required(),
            Input::create('recipientFirsName')->setValue(array_get($clientFIO, 1))
                ->setLabel(trans('orders::general.recipient-first-name'))
                ->required(),
            Input::create('recipientMiddleName')->setValue(array_get($clientFIO, 2))
                ->setLabel(trans('orders::general.recipient-middle-name'))
                ->required(),
            Input::create('recipientPhone', $order)->setValue($client->phone)
                ->setLabel(trans('orders::general.recipient-phone'))
                ->required(),
            Select::create('recipientCity')
                ->setLabel(trans('orders::general.recipient-city'))
                ->addClasses('changeCity')
                ->setOptions(['href' => route('admin.warehouses.city'), 'insert-block' => '#recipientWarehouses'])
                ->add($cities)
                ->setValue($order->city_ref)
                ->required(),
            Select::create('recipientWarehouses')
                ->setLabel(trans('orders::general.recipient-warehouse'))
                ->setOptions(['id' => 'recipientWarehouses'])
                ->add($recipientWarehouses)
                ->setValue($order->warehouse_ref)
        );

        //Information
        $cargoTypes = [];
        foreach (NovaPoshta::getCargoTypes() as $key => $types) {
            $cargoTypes[$types->Ref] = $types->Description;
        }
        $cargoDescription = [];
        foreach (NovaPoshta::getCargoDescriptionList() as $key => $types) {
            $cargoDescription[$types->Description] = $types->Description;
        }
        $fieldSetInformation = $form->fieldSet(6, FieldSet::COLOR_SUCCESS, trans('orders::general.delivery-info'));
        $fieldSetInformation->add(
            Select::create('delivery')
                ->setLabel('orders::general.delivery-type')
                ->add($cargoTypes)
                ->required(),
            Input::create('weight', $order)
                ->setLabel(trans('orders::general.delivery-weight'))
                ->required(),
            Input::create('volumeGeneral', $order)
                ->setLabel(trans('orders::general.delivery-volume-general'))
                ->required(),
            Input::create('seatsAmount', $order)
                ->setLabel(trans('orders::general.delivery-seats-amount'))
                ->required(),
            Input::create('cost')
                ->setDefaultValue($order->total_amount_as_number)
                ->setLabel(trans('orders::general.delivery-cost'))
                ->required(),
            Select::create('description')
                ->setLabel(trans('orders::general.delivery-description'))
                ->add($cargoDescription)
                ->required(),
            Input::create('packingNumber', $order)
                ->setType('number')
                ->setLabel(trans('orders::general.delivery-packing-number'))
                ->required(),
            Input::create('infoRegClientBarcodes')->setValue($order->id)->setOptions(['readonly'])
                ->setLabel(trans('orders::general.delivery-barcodes'))
                ->required(),
            DateTimePicker::create('preferredDeliveryDate')
                ->setLabel(trans('orders::general.delivery-delivery-date'))
                ->setDefaultValue(Carbon::now()->toDateString())
                ->required()
        );

        //Payment
        $paymentForms = [];
        foreach (NovaPoshta::getPaymentForms() as $key => $types) {
            $paymentForms[$types->Ref] = $types->Description;
        }
        $typesOfPayers = [];
        foreach (NovaPoshta::getTypesOfPayers() as $key => $types) {
            $typesOfPayers[$types->Ref] = $types->Description;
        }
        $fieldSetPayment = $form->fieldSet(6, FieldSet::COLOR_SUCCESS, trans('orders::general.payment-info'));
        $fieldSetPayment->add(
            Select::create('payerType')
                ->setLabel(trans('orders::general.payment-type'))
                ->add($typesOfPayers)
                ->required(),
            Select::create('paymentMethod')
                ->setLabel(trans('orders::general.payment-form'))
                ->add($paymentForms)
                ->setDefaultValue('Cash')
                ->required()
        );

        //serviceType
        $serviceTypes = [];
        foreach (NovaPoshta::getServiceTypes() as $key => $types) {
            $serviceTypes[$types->Ref] = $types->Description;
        }
        $fieldSetServiceType = $form->fieldSet(6, FieldSet::COLOR_SUCCESS, trans('orders::general.service-type'));
        $fieldSetServiceType->add(
            Select::create('serviceType')
                ->setLabel(false)
                ->setDefaultValue('WarehouseWarehouse')
                ->add($serviceTypes)
                ->required()
        );

        $fieldSetButton = $form->simpleFieldSet();
        $fieldSetButton->add(
            Submit::create('submit')
                ->setValue(trans('orders::general.change-ttn'))
                ->addClasses('btn', 'btn-primary')
                ->setLabel(false)
        );
        $form->doNotShowTopButtons();
        $form->doNotShowBottomButtons();
        return $form;
    }
}
