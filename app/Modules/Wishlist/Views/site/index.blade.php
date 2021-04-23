@php
/** @var string $products */
/** @var \App\Core\Modules\SystemPages\Models\SystemPage|null $page */

$layout = 'site._layouts.account';
$section = 'account-content';
if (Auth::guest()) {
    $layout = 'site._layouts.main';
    $section = 'layout-body';
}
@endphp

@extends($layout)

@section($section)
    @component('wishlist::site._wishlist-harness')
        <div class="grid">
            <div class="gcell gcell--12">
                @if($products)
                    <div class="grid _items-center _justify-between _p-md _def-p-lg wishlist-sticky-head" style="border-bottom: 1px solid #f2f2f2;">
                        <div class="gcell gcell--auto">
                            <div class="title title--size-h2">@lang('wishlist::site.my-wishlist')</div>
                        </div>
                        <div class="gcell gcell--12 _pt-md _def-pt-lg">
                            <div class="_color-gray4" data-wishlist-block-buy="@lang('wishlist::site.products-in-money')">
                                {!! Widget::show('wishlist::total-amount') !!}
                            </div>
                        </div>
                        <div class="gcell gcell--12 _pt-sm">
                            <div class="grid _items-center _justify-between _nmlr-def">
                                <div class="gcell gcell--auto _flex-grow _plr-def">
                                    <button class="button button--air _color-main _fill-main" data-wishlist-massive="buy">
                                        <span class="button__body">
                                            {!! SiteHelpers\SvgSpritemap::get('icon-shopping', [
                                                'class' => 'button__icon button__icon--before',
                                                'style' => 'width: 20px; height: 20px'
                                            ]) !!}
                                            <span class="button__text">@lang('wishlist::site.buy')</span>
                                        </span>
                                    </button>
                                </div>
                                <div class="gcell gcell--auto _flex-noshrink _plr-def _hide" data-wishlist-massive-control>
                                    <button class="button button--air" data-wishlist-massive="delete">
                                        <span class="button__body">
                                            {!! SiteHelpers\SvgSpritemap::get('icon-close', [
                                                'class' => 'button__icon button__icon--before',
                                                'style' => 'width: 11px; height: 11px'
                                            ]) !!}
                                            <span class="button__text">@lang('wishlist::site.delete')</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! $products !!}
                @else
                    <div class="title title--size-h2 _plr-lg _pt-lg _pb-md _m-none">@lang('wishlist::site.my-wishlist')</div>
                    <div class="_plr-lg _ptb-xs">@lang('wishlist::site.my-wishlist-is-empty-part-1')</div>
                    <div class="_plr-lg _ptb-xs">@lang('wishlist::site.my-wishlist-is-empty-part-2')</div>
                    <div class="_plr-lg _ptb-lg">
                        <a href="{{ route('site.categories') }}" class="button button--theme-default button--size-normal">
                            <span class="button__body">
                                <span class="button__text">@lang('wishlist::site.start-shopping')</span>
                            </span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endcomponent
@endsection
