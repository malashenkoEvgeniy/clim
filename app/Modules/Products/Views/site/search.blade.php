@php
/** @var \App\Modules\Products\Models\Product[]|\Illuminate\Pagination\LengthAwarePaginator $products */
/** @var string $query */
/** @var integer $total */
/** @var \App\Core\Modules\SystemPages\Models\SystemPage|null $page */
if(!$query) {
    $h1 = trans('products::site.search.no-results');
} else {
    $h1 = trans('products::site.search.results', ['total' => trans_choice('products::site.products-search', $total), 'query' => $query]);
}
@endphp

@extends('site._layouts.main')

@section('layout-body')
    {!! Widget::show('h1', 'box', $h1) !!}
    <div class="section _mb-lg">
        <div class="container">
            {!! Widget::show('products::sort-bar', $query && $products->count(), true) !!}
        </div>

        @if($query)
            <div class="container _mb-xl _def-mb-xxl">
                <div class="js-search-result" data-query="{{ $query }}">
                    {!! Widget::show('products::list', $products, true) !!}

                    @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <hr class="separator _color-gray3 _mtb-xl">
                        {!! $products->links('pagination.site') !!}
                    @endif
                </div>
            </div>
        @endif
    </div>
    {!! Widget::show('viewed::products') !!}
@endsection
