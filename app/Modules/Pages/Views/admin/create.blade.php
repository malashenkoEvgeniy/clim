@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.pages.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.pages.store']) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
