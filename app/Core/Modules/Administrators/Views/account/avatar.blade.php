@php
use \App\Core\Modules\Administrators\Images\AdminAvatar;
use \CustomForm\Image;
/** @var \App\Core\Modules\Administrators\Models\Admin $admin */
$image = Image::create(AdminAvatar::getField(), $admin->image);
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-body">
                {{ Form::open(['method' => 'put', 'files' => true]) }}
                    {!! $image->render() !!}
                    @if(!$image->getObject() || !$image->getObject()->exists)
                        <button type="submit" class="btn btn-primary btn-large">{{ __('admins::buttons.upload') }}</button>
                    @endif
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop
