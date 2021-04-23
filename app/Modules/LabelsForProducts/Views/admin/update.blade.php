@php
/** @var \CustomForm\Builder\Form $form */
$form->buttons->showCloseButton(route('admin.product-labels.index'));
$url = route('admin.product-labels.update', Route::current()->parameters);
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['method' => 'PUT', 'files' => true, 'url' => $url]) !!}
        {!! $form->render() !!}
    {!! Form::close() !!}
@stop
