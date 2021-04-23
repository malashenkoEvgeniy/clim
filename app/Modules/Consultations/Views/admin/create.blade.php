@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.consultations.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.consultations.store', 'files' => false]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
