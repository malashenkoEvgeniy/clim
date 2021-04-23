@php
	/** @var \CustomForm\Builder\Form $form */
    $form->buttons->showCloseButton(route('admin.seo_files.index'))
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
	{!! Form::open(['route' => 'admin.seo_files.store', 'files' => true]) !!}
		{!! $form->render() !!}
	{!! Form::close() !!}
@stop
