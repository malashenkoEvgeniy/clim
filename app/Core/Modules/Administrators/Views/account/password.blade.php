@extends('admin.layouts.main')

@section('content')
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-body">
                {{ Form::open(['method' => 'put']) }}
                {!! CustomForm\Password::create('current_password')->required()->render() !!}
                {!! CustomForm\Password::create('new_password')->required()->render() !!}
                {!! CustomForm\Password::create('new_password_confirmation')->required()->render() !!}
                <button type="submit" class="btn btn-primary btn-large">{{ __('buttons.save') }}</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop
