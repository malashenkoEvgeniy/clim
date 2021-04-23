@php
/** @var \CustomForm\Builder\Form $form */
$form->buttons->showCloseButton(route('admin.seo_scripts.index'));
$url = route('admin.seo_scripts.update', Route::current()->parameters);
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
	{!! Form::open(['method' => 'PUT', 'url' => $url]) !!}
		{!! $form->render() !!}
	{!! Form::close() !!}
@stop
