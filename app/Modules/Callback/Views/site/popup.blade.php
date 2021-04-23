{!! JsValidator::make($rules, [], [], '#' . $formId) !!}
<div id="popup-callback" class="popup popup--callback">
    <div class="popup__container">
        <div class="popup__head">
            <div class="grid _flex-nowrap">
                <div class="gcell gcell--auto _flex-noshrink _pr-sm">
                    {!! SiteHelpers\SvgSpritemap::get('icon-phone', [
                        'class' => 'svg-icon svg-icon--icon-phone',
                    ]) !!}
                </div>
                <div class="gcell gcell--auto _flex-grow">
                    <div class="popup__title">@lang('callback::site.order-callback')</div>
                    <div class="popup__desc">@lang('callback::site.we-will-call-you-back')</div>
                </div>
            </div>
        </div>
        <div class="popup__body">
            <div class="form form--callback">
                {!! Form::open(['route' => 'callback-send', 'class' => ['js-init', 'ajax-form'], 'id' => $formId]) !!}
                    <div class="form__body">
                        <div class="grid _nmtb-sm">
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input {{ $name ? 'has-value' : null }}">
                                    <div class="control__inner">
                                        <input class="control__field" type="text" name="name" id="callback-name" value="{{ $name }}">
                                        <label class="control__label" for="name">@lang('callback::site.name')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input {{ $phone ? 'has-value' : null }}">
                                    <div class="control__inner">
                                        <input class="control__field js-init" type="tel" name="phone" id="callback-phone" data-phonemask value="{{ $phone }}">
                                        <label class="control__label" for="phone">@lang('callback::site.phone') *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _pt-lg _pb-sm">
                                @component('site._widgets.checker.checker', [
                                    'attributes' => [
                                        'type' => 'checkbox',
                                        'name' => 'personal-data-processing',
                                        'required' => true,
                                    ]
                                ])
                                    * @lang('callback::site.agreement') →
                                    <a href="{{ config('db.basic.agreement_link') }}" target="_blank">@lang('global.more')</a>
                                    <label id="personal-data-processing-error" class="has-error" for="personal-data-processing" style="display: none;"></label>
                                @endcomponent
                            </div>
                        </div>
                    </div>
                    <div class="form__footer">
                        <div class="grid _justify-center">
                            <div class="gcell gcell--12 gcell--sm-10 gcell--md-8">
                                <div class="control control--submit">
                                    <button class="button button--theme-main button--size-normal button--width-full" type="submit">
                                        <span class="button__body">
                                            <span class="button__text">@lang('callback::site.order')</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($additions && is_array($additions) && count($additions) > 0)
                        <div>
                            <div class="hint hint--decore _text-center _mtb-def"><span>@lang('callback::site.or')</span></div>
                            <div class="_text-center">
                                @foreach($additions as $phone)
                                    @if(!is_null($phone->text_content))
                                        @include('site-custom.static.phone-number.phone-number', [
                                            'phone' => $phone,
                                            'link_mod_classes' => 'phone-number__link--size-lg',
                                            'help_classes' => '_mtb-sm',
                                        ])
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

