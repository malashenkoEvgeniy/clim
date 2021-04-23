@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.consultations.index'));
    $url = route('admin.consultations.update', Route::current()->parameters);
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['method' => 'PUT', 'url' => $url]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
