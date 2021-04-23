@php
/** @var \App\Modules\SeoLinks\Models\SeoLink[] $seoLink */
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
                        <th>{{ __('validation.attributes.name') }}</th>
                        <th>{{ __('validation.attributes.url') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($seoLinks AS $seoLink)
                        <tr>
                            <td>{{ $seoLink->current->name }}</td>
                            <td>{{ $seoLink->url }}</td>
                            <td>{!! Widget::active($seoLink, 'admin.seo_links.active') !!}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.seo_links.edit', $seoLink->id) !!}
                                {!! \App\Components\Buttons::delete('admin.seo_links.destroy', $seoLink->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $seoLinks->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
