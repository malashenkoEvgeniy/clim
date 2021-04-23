{!! JsValidator::make($rules, [], [], '#' . $formId); !!}
<div id="popup-consultation" class="popup popup--consultation">
    <div class="popup__container">
        <div class="popup__head">
            <div class="grid _flex-nowrap">
                <div class="gcell gcell--auto _flex-noshrink _pr-sm">
                    {!! SiteHelpers\SvgSpritemap::get('icon-ask-consultant', [
                        'class' => 'svg-icon svg-icon--icon-ask-consultant',
                    ]) !!}
                </div>
                <div class="gcell gcell--auto _flex-grow">
                    <div class="popup__title">@lang('consultations::site.order-consultation')</div>
                    <div class="popup__desc">@lang('consultations::site.we-will-call-you-back')</div>
                </div>
            </div>
        </div>
        <div class="popup__body">
            <div class="form form--consultation">
                {!! Form::open(['route' => 'consultation-send', 'class' => ['js-init', 'ajax-form'], 'id' => $formId]) !!}
                    <div class="form__body">
                        <div class="grid _nmtb-sm">
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input {{ $name ? 'has-value' : null }}">
                                    <div class="control__inner">
                                        <input class="control__field" type="text" name="name" id="consultations-name" value="{{ $name }}">
                                        <label class="control__label" for="name">@lang('consultations::site.name')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input {{ $phone ? 'has-value' : null }}">
                                    <div class="control__inner">
                                        <input class="control__field js-init" type="tel" name="phone" id="consultations-phone" data-phonemask value="{{ $phone }}">
                                        <label class="control__label" for="phone">@lang('consultations::site.phone') *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input">
                                    <div class="control__inner">
                                        <input class="control__field" type="text" name="question" id="consultation-question">
                                        <label class="control__label" for="question">@lang('consultations::site.question')</label>
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
                                    * @lang('consultations::site.agreement') →
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
                                            <span class="button__text">@lang('consultations::site.order')</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
