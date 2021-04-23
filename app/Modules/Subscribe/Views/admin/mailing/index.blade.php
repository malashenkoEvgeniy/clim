@php
    /** @var \CustomForm\Builder\Form $form */
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.subscribe.send', 'files' => true]) !!}
        {!! $form->render() !!}
    {!! Form::close() !!}
@stop
