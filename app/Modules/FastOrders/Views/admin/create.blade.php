@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.fast_orders.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.fast_orders.store', 'files' => false]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
