@php
/** @var \App\Modules\Orders\Models\Order $order */
$form = \App\Modules\Orders\Forms\OrderGenerateTtnForm::make($order);
@endphp

@if(CustomRoles::can('orders', 'edit'))
    {!! $form->open(['route' => ['admin.orders.generate-ttn', $order->id], 'class' => 'ajax-form', 'id' => 'generate-ttn', 'method' => 'POST']) !!}
    {!! $form->render() !!}
    {!! $form->close() !!}
@endif

