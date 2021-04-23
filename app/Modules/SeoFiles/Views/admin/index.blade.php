@php
/** @var \App\Modules\SeoFiles\Models\SeoFile[] $seoFiles */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('validation.attributes.file') }}</th>
                        <th>{{ __('seo_files::general.mime') }}</th>
                        <th>{{ __('seo_files::general.size') }}</th>
                        <th>{{ __('validation.attributes.updated_at') }}</th>
                        <th></th>
                    </tr>
                    @foreach($seoFiles AS $seoFile)
                        @if($seoFile->exists)
                            <tr>
                                <td>{!! Html::link($seoFile->url, $seoFile->name, ['target' => '_blank']) !!}</td>
                                <td>{{ $seoFile->mime }}</td>
                                <td>{{ $seoFile->size . ' ' . __('seo_files::general.byte') }}</td>
                                <td>{{ $seoFile->updated_at->toDateTimeString() }}</td>
                                <td>
                                    {!! \App\Components\Buttons::edit('admin.seo_files.edit', ['id' => $seoFile->id]) !!}
                                    {!! \App\Components\Buttons::delete('admin.seo_files.destroy', ['id' => $seoFile->id]) !!}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@stop
