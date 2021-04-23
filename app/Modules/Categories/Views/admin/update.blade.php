@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.categories.index'));
    $url = route('admin.categories.update', Route::current()->parameters);
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['method' => 'PUT', 'url' => $url, 'files' => true]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
