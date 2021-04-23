@php
/** @var \App\Modules\Reviews\Models\Review[]|\Illuminate\Database\Eloquent\Collection $reviews */
@endphp

@extends('site._layouts.main')

@section('layout-body')
    <div class="section">
        <div class="container">
            <div class="box box--gap _plr-def _ptb-xs _def-plr-lg _def-ptb-md">
                @if($reviews->isNotEmpty())
                    @include('reviews::site.widgets.reviews-list', [
                        'reviews' => $reviews,
                        'grid_mod_classes' => 'grid--1 grid--sm-2 grid--def-4',
                    ])
                    {!! $reviews->links('pagination.site') !!}
                    <hr class="separator _color-white _mtb-def">
                @else
                    <div class="_text-center">
                        <div class="wysiwyg">
                            <p>@lang('reviews::site.no-content')</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="box box--gap">
                <div class="container container--md">
                    <div class="title title--size-h2 _text-center">
                        @lang('reviews::site.send-review')
                    </div>
                    @include('reviews::site.widgets.forms.reviews')
                </div>
            </div>
        </div>
    </div>
@endsection


