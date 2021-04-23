@php
/** @var \App\Modules\Consultations\Models\Consultation[] $consultations */
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
                        <th>{{ __('validation.attributes.created_at') }}</th>
                        <th>{{ __('callback::general.status') }}</th>
                        <th></th>
                    </tr>
                    @foreach($consultations AS $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{!! Widget::active($item, 'admin.consultations.active') !!}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.consultations.edit', $item->id) !!}
                                {!! \App\Components\Buttons::delete('admin.consultations.destroy', $item->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $consultations->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
