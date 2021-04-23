@php
/** @var int $productId */
/** @var bool $isInComparison */
@endphp

<div class="item-card-controls__control _flex-noshrink">
    <button class="button button--theme-item-action button--size-normal {{ $isInComparison ? 'is-active' : null }}"
        type="button"
        data-comparelist-toggle="{{ $productId }}">
        <span class="button__body">
            {!! SiteHelpers\SvgSpritemap::get('icon-to-compare', [
                'class' => 'button__icon button__icon--before'
            ]) !!}
        </span>
    </button>
</div>
