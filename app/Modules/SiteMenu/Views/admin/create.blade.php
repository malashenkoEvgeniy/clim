@php
    /** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.site_menu.index', ['place' => \Route::current()->parameter('place')]))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['route' => ['admin.site_menu.store', 'place' => \Route::current()->parameter('place')], 'files' => false]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
