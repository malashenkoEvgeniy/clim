<button class="button button--theme-default button--size-collapse-normal button--width-full js-init" data-mfp="ajax" data-mfp-src="{{ $url }}">
    <span class="button__body">
        {!! SiteHelpers\SvgSpritemap::get('icon-megaphone', [
            'class' => 'button__icon button__icon--before'
        ]) !!}
        <span class="button__text button__text--double">{{ __('products-availability::site.button') }}</span>
    </span>
</button>
