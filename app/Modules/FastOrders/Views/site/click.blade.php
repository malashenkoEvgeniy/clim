<button class="button button--theme-white button--size-collapse-normal button--width-full js-init" data-mfp="ajax" data-mfp-src="{{ $url }}">
    <span class="button__body">
        {!! SiteHelpers\SvgSpritemap::get('icon-cursor', [
            'class' => 'button__icon button__icon--before'
        ]) !!}
        <span class="button__text button__text--double">@lang('products::site.one-click-buy')</span>
    </span>
</button>
