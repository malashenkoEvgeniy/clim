@php
    /** @var \App\Modules\Articles\Models\Article[] $articles */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        {!! \App\Modules\Articles\Filters\ArticlesFilter::showFilter() !!}
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('validation.attributes.name') }}</th>
                        <th>{{ __('global.url') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($articles AS $item)
                        <tr>
                            <td>{{ $item->current->name }}</td>
                            <td>{{ Html::link($item->link, null, ['target' => '_blank']) }}</td>
                            <td>{!! Widget::active($item, 'admin.articles.active') !!}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.articles.edit', $item->id) !!}
                                {!! \App\Components\Buttons::delete('admin.articles.destroy', $item->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $articles->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
