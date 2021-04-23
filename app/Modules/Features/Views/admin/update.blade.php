@php
/** @var \CustomForm\Builder\Form $form */
$form->buttons->showCloseButton(route('admin.features.index'));
$url = route('admin.features.update', Route::current()->parameters);
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['method' => 'PUT', 'files' => true, 'url' => $url]) !!}
        {!! $form->render() !!}
    {!! Form::close() !!}
@stop
