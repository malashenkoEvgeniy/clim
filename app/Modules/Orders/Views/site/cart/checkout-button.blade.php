@php
/** @var \App\Modules\Orders\Components\Cart\Cart $cart */
/** @var bool $canMakeOrder */
/** @var integer $minimumOrderAmount */
/** @var string $link */
@endphp

<div>
    <a {!! $canMakeOrder ? sprintf("href=\"%s\"", $link) : null !!} class="button button--theme-main button--size-normal {{ $canMakeOrder ? null : 'is-disabled' }}">
        <span class="button__body">
            {!! SiteHelpers\SvgSpritemap::get('icon-shopping', [
                'class' => 'button__icon button__icon--before'
            ]) !!}
            <span class="button__text">@lang('orders::site.to-checkout')</span>
        </span>
    </a>
</div>
