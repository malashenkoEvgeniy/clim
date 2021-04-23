@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.slideshow_simple.index'));
    $url = route('admin.slideshow_simple.update', Route::current()->parameters);
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['method' => 'PUT', 'files' => true, 'url' => $url]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
