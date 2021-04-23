@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.categories.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.categories.store', 'files' => true]) !!}
        {!! $form->render() !!}
    {!! Form::close() !!}
@stop
