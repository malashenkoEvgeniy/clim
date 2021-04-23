<div id="popup-one-click-buy" class="popup popup--one-click-buy">
    <div class="popup__container">
        <div class="popup__head">
            <div class="grid _flex-nowrap">
                <div class="gcell gcell--auto _flex-noshrink _pr-md">
                    {!! SiteHelpers\SvgSpritemap::get('icon-megaphone', [
                        'class' => 'svg-icon svg-icon--icon-shopping',
                    ]) !!}
                </div>
                <div class="gcell gcell--auto _flex-grow">
                    <div class="popup__title">@lang('products-availability::site.popup.send-order-availability')</div>
                    <div class="popup__desc">@lang('products-availability::site.popup.enter-the-email')</div>
                </div>
            </div>
        </div>
        {!! $validation !!}
        <div class="popup__body">
            <div class="form form--one-click-buy">
                {!! Form::open(['route' => 'products-availability-send', 'class' => ['js-init', 'ajax-form'], 'id' => $formId]) !!}
                    <div class="form__body">
                        <div class="grid _nmtb-sm">
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input {{ $email ? 'has-value' : null }}">
                                    <div class="control__inner">
                                        <input class="control__field js-init" type="email" name="email" value="{{ $email }}" id="email" required>
                                        <label class="control__label" for="email">Эл. почта *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _pt-lg _pb-sm">
                                @component('site._widgets.checker.checker', [
                                    'attributes' => [
                                        'type' => 'checkbox',
                                        'name' => 'personal-data-processing',
                                        'required' => true,
                                    ],
                                ])
                                    @lang('callback::site.agreement') →
                                    <a href="{{ config('db.basic.agreement_link') }}" target="_blank">@lang('global.more')</a>
                                    <label id="personal-data-processing-error" class="has-error" for="personal-data-processing" style="display: none;"></label>
                                @endcomponent
                            </div>
                        </div>
                    </div>
                    <div class="form__footer">
                        <div class="grid _justify-center">
                            <div class="gcell gcell-10 gcell--md-8">
                                <div class="control control--submit">
                                    <button class="button button--theme-main button--size-normal button--width-full" type="submit">
                                        <span class="button__body">
                                            <span class="button__text">@lang('products-availability::general.form-submit-button')</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                 {!! Form::hidden('product_id', $productId) !!}
                 {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
