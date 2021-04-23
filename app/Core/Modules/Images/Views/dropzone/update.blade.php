@php
/** @var \CustomForm\Builder\Form $form */
/** @var string $backUrl */
$form->buttons->showCloseButton($backUrl);
$url = route('admin.images.update', Route::current()->parameters + ['back' => $backUrl]);
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['method' => 'PUT', 'files' => true, 'url' => $url]) !!}
    {!! $form->render() !!}
    {!! Form::close() !!}
@stop
