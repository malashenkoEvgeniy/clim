<!doctype html>
<html lang="{{ app()->getLocale() }}" class="{{ browserizr()->cssClasses(['Mobile', 'Desktop'], 'browserizr-') }}">
<head>
    @include('site._widgets.head.head')
    {!! Widget::show('seo-metrics', 'head') !!}
    @include('site._widgets.microdata')
    {!! Widget::show('colors-schema') !!}
</head>
<body>
{!! Widget::show('seo-metrics', 'body') !!}
@yield('body')
<div hidden>
    <div id="popup-cart--template">
        <div id="popup-cart" class="popup popup--cart">
            <div class="popup__container">
                <div class="popup__body" data-cart-container="detailed">__cart__</div>
            </div>
        </div>
    </div>
</div>
<div class="fixed-button _def-hide">
    <button class="button button--size-normal button--theme-main js-init" data-mfp="inline" data-mfp-src="#popup-callback">
        <span class="button__body">
            {!! \SiteHelpers\SvgSpritemap::get('icon-phone', [
                'class' => 'button__icon button__icon--before'
            ]) !!}
        </span>
    </button>
</div>
{!! Widget::show('colors-panel') !!}
{!! Widget::show('demo-form') !!}
</body>
</html>
