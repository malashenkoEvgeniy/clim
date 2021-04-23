@php
$title = trans('users::site.my-account');
$dataToShow = [
    'validation.attributes.first_name' => Auth::user()->name,
    'validation.attributes.email' => Auth::user()->email,
    'validation.attributes.phone' => Auth::user()->phone,
];
@endphp

@extends('users::site.layouts.with-left-menu')

@section('layout-body')
    @if($message)
        <div class="gcell gcell--12 _ptb-sm _plr-lg">
            @component('site._widgets.alert.alert', [
                'alert_type' => 'secondary',
                'alert_icon' => 'icon-ok',
            ])
                <div>{{ $message }}</div>
            @endcomponent
        </div>
    @endif
    <div class="gcell gcell--12 _pb-lg _plr-lg _pt-def">
        <div class="grid _pb-md" style="border-bottom: 1px solid #f2f2f2;">
            @foreach($dataToShow as $label => $value)
                @if($value)
                    <div class="gcell gcell--12 _ptb-sm _sm-ptb-none">
                        <div class="grid _items-center _nmlr-xs">
                            <div class="gcell gcell--12 gcell--sm-4 _sm-ptb-sm _plr-xs">
                                <div class="_color-gray4" style="font-size: 1rem;">@lang($label):</div>
                            </div>
                            <div class="gcell gcell--12 gcell--sm-8 _sm-ptb-sm _plr-xs">
                                <div class="_color-gray8">{{ $value }}</div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="grid _nmlr-sm _pt-md">
            {!! Widget::show('social-networks') !!}
        </div>
    </div>
@endsection
