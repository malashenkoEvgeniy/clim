@php
/** @var \CustomForm\Builder\Form $form */
$form->buttons->showCloseButton(route('admin.currencies.index'));
$url = route('admin.currencies.update', Route::current()->parameters);
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['method' => 'PUT', 'url' => $url, 'files' => true]) !!}
        {!! $form->render() !!}
    {!! Form::close() !!}
@stop
