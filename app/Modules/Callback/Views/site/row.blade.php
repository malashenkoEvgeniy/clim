<div class="section">
    <div class="container">
        <div class="gcell gcell--def-12 gcell--lg-12 _mb-lg">
            <div class="gcell gcell--def-6 gcell--lg-6 _ml-auto _mr-auto _mt-none _mb-none _text-center">
                <div class="gcell gcell--auto _flex-grow  _def-justify-center _items-center">
                    <div class="popup__title">@lang('callback::site.consult')</div>
                    <div class="popup__desc gcell--def-8 _ml-auto _mr-auto _mt-none _mb-none _text-center _mt-xs _mb-xs">@lang('callback::site.ask-question')</div>
                </div>
                <button class="button button--theme-default button--size-normal js-init" data-mfp="inline" data-mfp-src="#popup-callback">
                    <span class="button__body">
                    {!! SiteHelpers\SvgSpritemap::get('icon-phone', [
                        'class' => 'button__icon button__icon--before'
                    ]) !!}
                        <span class="button__text">@lang('callback::site.button')</span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>