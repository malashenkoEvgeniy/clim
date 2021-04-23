@php
/** @var \App\Modules\SeoRedirects\Models\SeoRedirect[] $seoRedirect */
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
                        <th>{{ __('seo_redirects::general.link_from') }}</th>
                        <th>{{ __('seo_redirects::general.link_to') }}</th>
                        <th>{{ __('validation.attributes.type') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($seoRedirects AS $seoRedirect)
                        <tr>
                            <td>{{ $seoRedirect->link_from }}</td>
                            <td>{{ $seoRedirect->link_to }}</td>
                            <td>{{ $seoRedirect->type }}</td>
                            <td>{!! Widget::active($seoRedirect, 'admin.seo_redirects.active') !!}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.seo_redirects.edit', $seoRedirect->id) !!}
                                {!! \App\Components\Buttons::delete('admin.seo_redirects.destroy', $seoRedirect->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="text-center">{{ $seoRedirects->appends(request()->except('page'))->links() }}</div>
    </div>
@stop
