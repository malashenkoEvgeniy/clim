@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.products_availability.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.products_availability.store', 'files' => false]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
