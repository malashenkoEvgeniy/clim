@php
    /** @var string $type */
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.comments.index', ['type' => $type]))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => ['admin.comments.store', 'type' => $type]]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
