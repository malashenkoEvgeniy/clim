@php
/** @var \App\Modules\SeoTemplates\Models\SeoTemplate[] $seoTemplates */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('validation.attributes.name') }}</th>
                        <th></th>
                    </tr>
                    @foreach($seoTemplates AS $seoTemplate)
                        <tr>
                            <td>{{ $seoTemplate->current->name }}</td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.seo_templates.edit', $seoTemplate->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@stop
