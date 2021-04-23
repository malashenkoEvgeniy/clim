@php
    /** @var \App\Components\Settings\SettingsGroup $group */
@endphp

@extends('admin.layouts.main')

@section('content-no-row')
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-body">
                <dl class="dl-vertical">
                    @foreach($group->getAll() as $element)
                        <dt>{{ __($element->getFormElement()->getLabel()) }}</dt>
                        <dd class="margin-bottom">{!! $element->getValue() ?: '&mdash;' !!}</dd>
                    @endforeach
                </dl>
                <div class="right-side freed-width">
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-block btn-flat btn-default">
                        {{ __('global.back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop
