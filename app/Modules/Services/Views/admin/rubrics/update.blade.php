@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.services_rubrics.index'));
    $url = route('admin.services_rubrics.update', Route::current()->parameters);
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['method' => 'PUT', 'url' => $url, 'files' => true]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
