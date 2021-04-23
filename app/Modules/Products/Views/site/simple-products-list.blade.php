@php
    /** @var \App\Modules\Products\Models\Product[]|Illuminate\Pagination\LengthAwarePaginator $products */
@endphp

@extends('site._layouts.main')

@section('layout-body')
    <div class="section _mb-lg">
        <div class="container">
            <div class="grid grid--1" id="filter">
                <div class="gcell gcell--def-12">
                    <div class="box _def-ml-xxs">
                        {!! Widget::show('products::sort-bar', true) !!}
                    </div>
                    <div class="_def-ml-xxs">
                        {!! Widget::show('products::list', $products, true) !!}

                        @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <hr class="separator _color-gray3 _mtb-xl">
                            {!! $products->links('pagination.site') !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
