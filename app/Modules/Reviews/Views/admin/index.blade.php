@php
/** @var \App\Modules\Reviews\Models\Review[] $reviews */
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
                        <th>{{ __('validation.attributes.user_id') }}</th>
                        <th>{{ __('reviews::general.publishing_date') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($reviews AS $review)
                        <tr>
                            <td>{{ $review->name }}</td>
                            <td>{!! $review->email ? Html::mailto($review->email) : '&mdash;' !!}</td>
                            <td>{!! Widget::show('short-user-information', $review->user) ?? '&mdash;' !!}</td>
                            <td>{!! $review->publish_date ?? '&mdash;' !!}</td>
                            <td>{!! Widget::active($review, 'admin.reviews.active') !!}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.reviews.edit', $review->id) !!}
                                {!! \App\Components\Buttons::delete('admin.reviews.destroy', $review->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $reviews->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
