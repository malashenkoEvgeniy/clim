@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.users.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['method' => 'PUT', 'url' => route('admin.users.update', Route::current()->parameters)]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
