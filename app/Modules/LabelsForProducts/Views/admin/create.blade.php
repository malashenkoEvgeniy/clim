@php
/** @var \CustomForm\Builder\Form $form */
$form->buttons->showCloseButton(route('admin.product-labels.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.product-labels.store', 'files' => true]) !!}
        {!! $form->render() !!}
    {!! Form::close() !!}
@stop
