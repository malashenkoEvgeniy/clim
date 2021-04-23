@php
    /** @var \App\Core\Modules\Administrators\Models\Admin $admin */
    /** @var array $languages */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-body">
                {{ Form::open(['method' => 'put']) }}
                {!! CustomForm\Input::create('first_name', $admin)->required()->render() !!}
                {!! CustomForm\Input::create('email', $admin)->required()->render() !!}
                <button type="submit" class="btn btn-primary btn-large">{{ __('buttons.save') }}</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop
