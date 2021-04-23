@php
/** @var \App\Modules\Products\Models\ProductGroup[]|Illuminate\Pagination\LengthAwarePaginator $groups */
/** @var bool $sortable */
$sortable = $sortable ?? true;
@endphp

@extends('site._layouts.main')

@section('layout-body')
    <div class="section _mb-lg">
        <div class="container">
            <div class="grid grid--1" id="filter">
                <div class="gcell gcell--def-12">
                    @if($sortable)
                        <div class="box _def-ml-xxs">
                            {!! Widget::show('products::sort-bar', true) !!}
                        </div>
                    @endif
                    <div class="_def-ml-xxs">
                        {!! Widget::show('products::groups-list', $groups, true) !!}
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
