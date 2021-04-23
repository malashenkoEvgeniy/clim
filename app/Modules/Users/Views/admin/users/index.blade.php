@php
    /** @var \App\Modules\Users\Models\User[] $users */
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
                        <th>{{ __('validation.attributes.phone') }}</th>
                        <th>{{ __('validation.attributes.email') }}</th>
                        <th>{{ __('users::general.attributes.created_at') }}</th>
                        @if(Route::currentRouteNamed('admin.users.index'))
                            <th></th>
                        @endif
                        <th></th>
                    </tr>
                    @foreach($users AS $user)
                        <tr>
                            <td>{{ $user->name ?? '&mdash;' }}</td>
                            <td>{!! $user->phone ?? '&mdash;' !!}</td>
                            <td>{{ Html::mailto($user->email) }}</td>
                            <td>{{ $user->created_at->format('d.m.Y, H:i') }}</td>
                            @if(Route::currentRouteNamed('admin.users.index'))
                                <td>{!! Widget::active($user, 'admin.users.active') !!}</td>
                            @endif
                            <td>
                                @if($user->trashed())
                                    {!! \App\Components\Buttons::restore('admin.users.restore', $user->id) !!}
                                @else
                                    {!! \App\Components\Buttons::edit('admin.users.edit', $user->id) !!}
                                    {!! \App\Components\Buttons::delete('admin.users.destroy', $user->id) !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $users->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
