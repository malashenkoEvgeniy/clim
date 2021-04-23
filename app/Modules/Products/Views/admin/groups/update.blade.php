@php
/** @var \CustomForm\Builder\Form $form */
/** @var \App\Modules\Products\Models\ProductGroup $group */
$form->buttons->showCloseButton(route('admin.groups.index'));
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    {!! Form::open(['method' => 'PUT', 'route' => ['admin.groups.update', $group->id], 'files' => true]) !!}
        {!! $form->render() !!}
    {!! Form::close() !!}
@stop
