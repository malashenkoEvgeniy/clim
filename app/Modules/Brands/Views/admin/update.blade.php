@php
/** @var \CustomForm\Builder\Form $form */
$form->buttons->showCloseButton(route('admin.brands.index'));
$url = route('admin.brands.update', Route::current()->parameters);
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['method' => 'PUT', 'files' => true, 'url' => $url]) !!}
        {!! $form->render() !!}
    {!! Form::close() !!}
@stop
