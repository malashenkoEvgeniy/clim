@php
/** @var \App\Modules\Products\Models\Product $product */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Modules\Products\Models\Product[] $related */

$hideH1 = true;
@endphp

@extends('site._layouts.main')

@if($product->microdata)
    @push('microdata')
        <script type="application/ld+json">/*<![CDATA[*/{!! $product->microdata !!}/*]]>*/</script>
    @endpush
@endif

@section('layout-body')
    <div class="section _mb-def">
        <div class="container">
            <div class="box">
                <div class="grid _items-center">
                    <div class="gcell _flex-grow _pr-sm">
                        <h1 class="title title--size-h1">
                            {!! Seo::site()->getH1() !!}
                        </h1>
                    </div>
                    <div class="gcell _flex-noshrink">
                        @if($product->group && $product->group->relationExists('comments'))
                            <div class="grid _items-center _ptb-xs">
                                <div class="gcell">
                                    @include('site._widgets.stars-block.stars-block', [
                                        'count' => $product->group->mark,
                                    ])
                                </div>
                                <div class="gcell _pl-sm">
                                    <a class="link link--main text--size-13" data-wstabs-ns="product" data-wstabs-button="review">
                                        @if ($product->group->comments->count())
                                            {!! trans_choice('products::site.products-review', $product->group->comments->count()) !!}
                                        @else
                                            @lang('products::site.products-review-write')
                                        @endif
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            @include('products::site.widgets.product.product', [
                'tabs' => $tabs,
            ])
        </div>
    </div>
    @if($related->isNotEmpty())
        <div class="section _mb-lg">
            <div class="container">
                <div class="grid grid--auto _justify-between _items-center _mt-lg _def-mt-xxl _pb-def">
                    <div class="gcell _mb-def _mr-def">
                        <div class="title title--size-h2">{{ $product->group->current->text_related ?: __('products::site.related') }}</div>
                    </div>
                    <div class="gcell _mb-def _self-end _md-show">
                        @include('products::site.widgets.product.arrows.items')
                    </div>
                </div>
                @include('products::site.widgets.item-list.item-slider', [
                    'preset' => 'SlickItemWithArrow',
                    'add_dot_classes' => '_md-hide',
                    'groups' => $related
                ])
            </div>
        </div>
    @endif
    {!! Widget::show('brands::our-brands') !!}
    {!! Widget::show('viewed::products', $product->id) !!}
@endsection
