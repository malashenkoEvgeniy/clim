@php
/** @var \Symfony\Component\HttpKernel\Exception\HttpException $exception */
@endphp

@extends('admin.layouts.error')

@section('content')
    <h2 class="headline text-yellow" style="text-align: center; font-size: 70px; margin: 0; font-weight: bold;">{{ $exception->getStatusCode() }}</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> Something went wrong.</h3>
        <p>
            We could not find the page you were looking for.
            Meanwhile, you may <a href="{{ route('admin.dashboard') }}">return to dashboard</a> or try using the search form.
        </p>
    </div>
@stop
