@php
/** @var \App\Modules\Orders\Models\Order $order */
/** @var \CustomForm\Builder\Form $form */
$form->buttons->showCloseButton(route('admin.orders.show', $order->id));
$form->buttons->doNotShowSaveAndAddButton();
$form->buttons->doNotShowSaveAndCloseButton();
$url = route('admin.orders.update', Route::current()->parameters);
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['method' => 'PUT', 'url' => $url]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
