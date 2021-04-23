@php
	/** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.seo_scripts.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
	{!! Form::open(['route' => 'admin.seo_scripts.store']) !!}
		{!! $form->render() !!}
	{!! Form::close() !!}
@stop
