@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.fast_orders.index'));
    $url = route('admin.fast_orders.update', Route::current()->parameters);
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['method' => 'PUT', 'url' => $url]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
