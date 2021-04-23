@extends('admin.layouts.main')

@section('content-no-row')
    <div class="row">
        {!! Widget::position('dashboard-fast-stat') !!}
    </div>

    {!! Widget::position('dashboard') !!}
@stop
