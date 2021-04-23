@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.callback.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.callback.store', 'files' => false]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
