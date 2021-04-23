@php
/** @var \App\Modules\SeoScripts\Models\SeoScript[] $seoScripts */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('validation.attributes.name') }}</th>
                        <th>{{ __('seo_scripts::general.place') }}</th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach($seoScripts AS $seoScript)
                        <tr>
                            <td>{{ $seoScript->name }}</td>
                            <td>{{ trans(config('seo_scripts.places.' . $seoScript->place, 'Unknown')) }}</td>
                            <td>{!! Widget::active($seoScript, 'admin.seo_scripts.active') !!}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.seo_scripts.edit', $seoScript->id) !!}
                                {!! \App\Components\Buttons::delete('admin.seo_scripts.destroy', $seoScript->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@stop
