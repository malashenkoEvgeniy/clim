@php
    /** @var \App\Modules\Currencies\Models\Currency[] $currencies */
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>{{ __('validation.attributes.name') }}</th>
                        <th>{{ __('currencies::general.attributes.multiplier') }}</th>
                        <th>{{ __('currencies::general.attributes.default_on_site') }}</th>
                        <th>{{ __('currencies::general.attributes.default_in_admin_panel') }}</th>
                        <th></th>
                    </tr>
                    @foreach($currencies AS $currency)
                        <tr>
                            <td>{{ $currency->name }}, {{ $currency->sign }}</td>
                            <td>{{ $currency->multiplier }}</td>
                            <td>
                                @if($currency->default_on_site === true)
                                    <i class="fa fa-dot-circle-o text-green text-bold"></i>
                                @elseif(CustomRoles::can('currencies', 'update'))
                                    {{ Html::link(
                                        route('admin.currencies.default-on-site', ['currency' => $currency->id]),
                                        '<i class="fa fa-circle-o text-gray text-bold"></i>',
                                        [],
                                        null,
                                        false
                                    ) }}
                                @else
                                    <i class="fa fa-circle-o text-gray text-bold"></i>
                                @endif
                            </td>
                            <td>
                                @if($currency->default_in_admin_panel === true)
                                    <i class="fa fa-dot-circle-o text-green text-bold"></i>
                                @elseif(CustomRoles::can('currencies', 'update'))
                                    {{ Html::link(
                                        route('admin.currencies.default-in-admin-panel', ['currency' => $currency->id]),
                                        '<i class="fa fa-circle-o text-gray text-bold"></i>',
                                        [],
                                        null,
                                        false
                                    ) }}
                                @else
                                    <i class="fa fa-circle-o text-gray text-bold"></i>
                                @endif
                            </td>
                            <td>
                                {!! \App\Components\Buttons::edit('admin.currencies.edit', $currency->id) !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@stop
