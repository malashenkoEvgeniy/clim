@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.articles.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.articles.store', 'files' => true]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
