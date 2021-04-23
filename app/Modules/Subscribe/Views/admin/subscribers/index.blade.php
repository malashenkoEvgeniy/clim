@php
    /** @var \App\Modules\Subscribe\Models\Subscriber[] $subscribers */
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
                        <th>{{ __('validation.attributes.created_at') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($subscribers AS $subscriber)
                        <tr>
                            <td>{{ $subscriber->name }}</td>
                            <td>{{ $subscriber->email }}</td>
                            <td>{{ $subscriber->created_at->toDateTimeString() }}</td>
                            <td>{!! Widget::active($subscriber, 'admin.subscribers.active') !!}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.subscribers.edit', $subscriber->id) !!}
                                {!! \App\Components\Buttons::delete('admin.subscribers.destroy', $subscriber->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $subscribers->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
