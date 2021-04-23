@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.subscribers.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.subscribers.store', 'files' => false]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
