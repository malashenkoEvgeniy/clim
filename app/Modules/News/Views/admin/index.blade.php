@php
    /** @var \App\Modules\News\Models\News[] $news */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        {!! \App\Core\Modules\News\Filters\NewsFilter::showFilter() !!}
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('validation.attributes.name') }}</th>
                        <th>{{ __('validation.attributes.published_at') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($news AS $item)
                        <tr>
                            <td>{{ Html::link($item->link, $item->current->name, ['target' => '_blank']) }}</td>
                            <td>{!! $item->published_at ?\Illuminate\Support\Carbon::parse($item->published_at): '&mdash;' !!}</td>
                            <td>{!! Widget::active($item) !!}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.news.edit', $item->id) !!}
                                {!! \App\Components\Buttons::delete('admin.news.destroy', $item->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $news->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
