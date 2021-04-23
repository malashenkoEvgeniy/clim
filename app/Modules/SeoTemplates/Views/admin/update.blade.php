@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.seo_templates.index'));
    $url = route('admin.seo_templates.update', Route::current()->parameters);
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['method' => 'PUT', 'url' => $url]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
