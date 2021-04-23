@php
/** @var int $categoryId */
/** @var \App\Modules\Products\Models\ProductGroup[]|Illuminate\Pagination\LengthAwarePaginator $groups */
@endphp

@extends('site._layouts.main')

@section('layout-body')
    <div class="section _mb-lg">
        <div class="container">
            <div class="grid grid--1" id="filter">
                <div class="gcell gcell--def-3 gcell--lg-1-of-5">
                    <div class="box">
                        <div class="_def-show">
                            {!! Widget::show('categories::in-filter') !!}
                            {!! Widget::show('categories::kids', $categoryId) !!}
                        </div>
                        <div class="mobile-filter">
                            <div class="mobile-filter__overlay js-filter-close"></div>
                            <div class="mobile-filter__body">
                                {!! $filter !!}
                            </div>
                        </div>
                        <div class="_def-hide">
                            <div class="grid _justify-center">
                                <div class="gcell">
                                    <button type="button"
                                            class="button button--theme-main button--size-normal button--width-full js-filter-show">
                                        <span class="button__body">
                                            {!! SiteHelpers\SvgSpritemap::get('icon-filter', [
                                                'class' => 'button__icon button__icon--before'
                                            ]) !!}
                                            <span class="button__text">@lang('products::site.filter-btn')</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr class="separator _color-gray2 _mtb-md">
                        <!--links_block-->
                    </div>
                </div>
                <div class="gcell gcell--def-9 gcell--lg-4-of-5">
                    <div class="box -def-ml-xxs">
                        {!! Widget::show('categories::image-kids', $categoryId) !!}
                    </div>
                    <div class="box _def-ml-xxs">
                        {!! Widget::show('products::sort-bar', true) !!}
                        {!! Widget::show('products::chosen-parameters-in-filter') !!}
                    </div>
                    <div class="_def-ml-xxs">
                        {!! Widget::show('products::groups-list', $groups) !!}

                        @if($groups instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <hr class="separator _color-gray3 _mtb-xl">
                            {!! $groups->links('pagination.site') !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
