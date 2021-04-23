@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.seo_redirects.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => 'admin.seo_redirects.store']) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
