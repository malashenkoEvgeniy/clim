@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.reviews.index'));
    $url = route('admin.reviews.update', Route::current()->parameters);
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['method' => 'PUT', 'url' => $url, 'files' => true]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
