@php
    /** @var \App\Core\Modules\Administrators\Models\Role[] $roles */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('validation.attributes.name') }}</th>
                        <th>{{ __('validation.attributes.created_at') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($roles AS $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->created_at->format('d.m.Y, H:i') }}</td>
                            <td>{!! Widget::active($role, 'admin.roles.active') !!}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.roles.edit', $role->id) !!}
                                {!! \App\Components\Buttons::delete('admin.roles.destroy', $role->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $roles->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
