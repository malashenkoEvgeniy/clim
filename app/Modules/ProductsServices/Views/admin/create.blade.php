@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.products-services.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.products-services.store']) !!}
        {!! $form->render() !!}
    {!! Form::close() !!}
@stop
