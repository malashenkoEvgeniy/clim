@php
    /** @var \App\Core\Modules\Administrators\Models\Admin[] $admins */
    /** @var string $filter */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        {!! $filter !!}
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('validation.attributes.first_name') }}</th>
                        <th>{{ __('validation.attributes.email') }}</th>
                        <th>{{ __('admins::attributes.roles') }}</th>
                        <th>{{ __('admins::attributes.created_at') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($admins AS $admin)
                        <tr>
                            <td>{{ $admin->first_name }}</td>
                            <td>{{ Html::mailto($admin->email) }}</td>
                            <td>{{ $admin->roles_names }}</td>
                            <td>{{ $admin->created_at->format('d.m.Y, H:i') }}</td>
                            <td>{!! Widget::active($admin, 'admin.admins.active') !!}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.admins.edit', $admin->id) !!}
                                {!! \App\Components\Buttons::delete('admin.admins.destroy', $admin->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $admins->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
