@php
/** @var \CustomForm\Builder\Form $form */
$form->buttons->showCloseButton(route('admin.orders-statuses.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.orders-statuses.store']) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
