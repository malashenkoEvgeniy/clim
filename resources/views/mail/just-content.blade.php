@extends('mail.layouts.main')

@section('subject'){{ $subject }}@stop

@section('header'){{ $subject }}@stop

@section('content')
    {!! $content !!}
@stop
