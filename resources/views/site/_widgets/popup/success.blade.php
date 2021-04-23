<div class="popup popup--callback">
    <div class="popup__container">
        <div class="popup__head">
            <div class="grid _flex-nowrap _justify-center">
                <div class="gcell gcell--auto _flex-noshrink _pr-sm">
                    {!! SiteHelpers\SvgSpritemap::get('icon-ok', [
                        'class' => 'svg-icon svg-icon--icon-phone',
                    ]) !!}
                </div>
                <div class="gcell gcell--auto">
                    <div class="popup__title">@lang('messages.thank')</div>
                </div>
            </div>
        </div>
        <div class="popup__body">
            <div class="wysiwyg js-init" data-wrap-media data-prismjs data-draggable-table>
                <p class="_text-center">{!! $content !!}</p>
            </div>
        </div>
        <div class="popup__footer _text-center">
            <button class="button button--size-normal button--theme-main js-magnific-close">
                <span class="button__body">
                    {!! SiteHelpers\SvgSpritemap::get('icon-ok', [
                        'class' => 'button__icon button__icon--before'
                    ]) !!}
                    <span class="button__text">@lang('messages.ok')</span>
                </span>
            </button>
        </div>
    </div>
</div>

