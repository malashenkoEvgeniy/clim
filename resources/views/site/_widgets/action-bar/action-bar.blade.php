@php
	$indexView = Route::currentRouteName() === 'site.home';
	$_if_images_exists = true;
@endphp
{{--<div class="section section--search-mobile{{ $indexView ? '' : ' section--sticky-bar' }}" data-action-bar-section>--}}
{{--    <div class="container">--}}
{{--        <div class="action-bar">--}}
{{--            <div class="action-bar__control action-bar__control--small _def-hide">--}}
{{--                <div tabindex="0" class="action-bar-control _justify-center js-search-close">--}}
{{--                    {!! SiteHelpers\SvgSpritemap::get('icon-back', ['width' => '20', 'height' => '20']) !!}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            {!! Widget::show('categories::main-menu') !!}--}}

{{--            {!! Widget::show('contacts', 'header') !!}--}}
{{--            {!! Widget::show('products::search-bar') !!}--}}
{{--            {!! Widget::show('compare::action-bar') !!}--}}
{{--            {!! Widget::show('wishlist::action-bar') !!}--}}
{{--            {!! Widget::show('orders::cart::splash-button') !!}--}}
{{--            {!! Widget::show('categories::main-menu-children') !!}--}}

{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
@if($indexView)
    {!! Widget::show('slideshow') !!}
@endif
