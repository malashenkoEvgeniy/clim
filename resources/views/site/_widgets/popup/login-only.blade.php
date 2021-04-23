<div id="popup-login-only" class="popup popup--login-only">
    <div class="popup__container">
        <div class="popup__head">
            <div class="grid _flex-nowrap">
                <div class="gcell gcell--auto _flex-noshrink _pr-sm">
                    {!! SiteHelpers\SvgSpritemap::get('icon-user', [
						'class' => 'svg-icon svg-icon--icon-user',
					]) !!}
                </div>
                <div class="gcell gcell--auto _flex-grow">
                    <div class="popup__title">@lang('users::site.sing-in')</div>
                    <div class="popup__desc">@lang('users::site.benefits-after-login')</div>
                </div>
            </div>
        </div>
        <div class="popup__body">
            @php
                $idModifier = $idModifier ?? '';
				$formId = $formId ?? 'login-form' . rand(1, 99999);
            @endphp
            <div class="form form--login">
                {!! Form::open(['route' => 'site.login', 'method' => 'POST', 'class' => ['ajax-form'], 'id' => $formId]) !!}
                <div class="form__body">
                    <div class="grid _nmtb-sm">
                        @if((bool)config('db.users.auth-by-phone') === true)
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input">
                                    <div class="control__inner">
                                        <input class="control__field js-init" type="tel" name="phone"
                                               id="{{ $idModifier }}login-phone" data-phonemask required>
                                        <label class="control__label" for="login-phone">@lang('users::site.seo.your-phone')</label>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="gcell gcell--12 _ptb-sm">
                                <div class="control control--input">
                                    <div class="control__inner">
                                        <input class="control__field" type="email" name="email"
                                               id="{{ $idModifier }}login-email" required>
                                        <label class="control__label" for="{{ $idModifier }}login-email">@lang('users::site.seo.your-email')</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="gcell gcell--12 _ptb-sm">
                            <div class="control control--input">
                                <div class="control__inner">
                                    <input class="control__field" type="password" name="password" id="{{ $idModifier }}login-pass" required>
                                    <label class="control__label" for="{{ $idModifier }}login-pass">@lang('users::site.seo.your-password')</label>
                                </div>
                            </div>
                        </div>
                        <div class="gcell gcell--12 _pt-lg _pb-sm">
                            <div class="grid _justify-center _md-justify-between _items-center">
                                <div class="gcell gcell--12 gcell--xs-6 _text-center _xs-text-left">
                                    @component('site._widgets.checker.checker', ['attributes' => [
                                        'type' => 'checkbox',
                                        'name' => 'remember',
                                    ]])
                                        @lang('auth.remember-me')
                                    @endcomponent
                                </div>
                                <div class="gcell gcell--10 gcell--xs-6 _mt-md _xs-mt-none _text-center _xs-text-right">
                                    <div class="control control--submit">
                                        <button class="button button--theme-main button--size-normal button--width-full" type="submit">
                                            <span class="button__body">
                                                <span class="button__text">@lang('users::site.enter')</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="popup__social-section">
        <div class="popup__container _mt-xl">
            <div class="popup__desc _text-center _mb-def">@lang('users::site.through-your-social-network')</div>
            <div class="grid _nmlr-sm">
                @foreach(config('mock.social-login-links') as $network => $item)
                    <div class="gcell gcell--4 _plr-sm">
                        <button type="button"
                                class="network-link network-link--{{ $network }} network-link--{{ $network }}-hover network-link--social-login"
                                title="{{ $item->text_content }}"
                        >
                            {!! SiteHelpers\SvgSpritemap::get($item->symbol, [
								'class' => 'network-link__symbol network-link__symbol--' . $network
							]) !!}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
