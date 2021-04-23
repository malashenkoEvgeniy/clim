@php
/** @var \CustomForm\Builder\Form $form */
$form->buttons->showCloseButton(route('admin.groups.index'));
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => ['admin.groups.store'], 'files' => true]) !!}
        {!! $form->render() !!}
    {!! Form::close() !!}
@stop
