@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.roles.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.roles.store']) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
