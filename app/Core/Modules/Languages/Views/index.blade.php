@php
    /** @var \App\Core\Modules\Languages\Models\Language[] $languages */
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    <div class="col-xs-12">
        <div class="callout callout-warning">
            <h4>{{ __('langs::messages.warning-title') }}</h4>
            <p>{{ __('langs::messages.warning-body') }}</p>
        </div>
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('validation.attributes.name') }}</th>
                        <th>{{ __('validation.attributes.slug') }}</th>
                        <th>{{ __('validation.attributes.default') }}</th>
                    </tr>
                    @foreach($languages AS $language)
                        <tr>
                            <td>{{ $language->name }}</td>
                            <td>{{ $language->slug }}</td>
                            <td>
                                @if($language->default === true)
                                    <i class="fa fa-dot-circle-o text-green text-bold"></i>
                                @elseif(CustomRoles::can('langs', 'update'))
                                    {{ Html::link(
                                        route('admin.languages.default', ['language' => $language->id]),
                                        '<i class="fa fa-circle-o text-gray text-bold"></i>',
                                        [],
                                        null,
                                        false
                                    ) }}
                                @else
                                    <i class="fa fa-circle-o text-gray text-bold"></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@stop
