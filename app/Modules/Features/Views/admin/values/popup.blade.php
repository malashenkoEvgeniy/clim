@extends('admin.layouts.popup')

@section('content')
    {!! Form::open(['id' => $formId, 'url' => $url, 'class' => 'ajax-form', 'method' => $method ?? 'POST']) !!}
        {!! $form->render() !!}
    {!! Form::close() !!}
    {!! $validation->render() !!}
@stop
