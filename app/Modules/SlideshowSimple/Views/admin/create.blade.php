@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.slideshow_simple.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.slideshow_simple.store', 'files' => true]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
