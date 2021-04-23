@extends('site._layouts.account')

{{-- TODO Убрать и передавать значения с контроллера --}}
@push('viewTitle', 'Изменение пароля')
{{-- ENDTODO Убрать и передавать значения с контроллера --}}

@section('account-content')
	<div class="account account--password-change">
		<div class="grid">
			<div class="gcell gcell--12 gcell--def-8 _p-lg">
				<div class="grid _nm-lg">
					<div class="gcell gcell--12 _pt-lg _plr-lg _pb-def">
                        @include('site.account._heading', ['title' => 'Изменение пароля'])
					</div>
					<div class="gcell gcell--12 _p-none">
                        <div class="form form--password-change">
                            <form>
                                <div class="form__body">
                                    <div class="grid">
                                        <div class="gcell gcell--12 _pt-sm _pb-lg _plr-lg">
                                            <div class="grid _nmtb-lg">
                                                {{--<div class="gcell gcell--12 _ptb-lg">
                                                    @component('site._widgets.alert.alert', [
                                                        'alert_type' => 'danger',
                                                        'alert_icon' => 'icon-disappoint',
                                                    ])
                                                        <div>Не верный текущий пароль</div>
                                                    @endcomponent
                                                </div>--}}
                                                <div class="gcell gcell--12 _pt-lg _pb-sm">
                                                    <div class="control control--input">
                                                        <div class="control__inner">
                                                            <input class="control__field" type="password" name="profile-current-password" id="profile-current-password">
                                                            <label class="control__label" for="profile-current-password">Текущий пароль</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="gcell gcell--12 _ptb-sm">
                                                    <div class="control control--input">
                                                        <div class="control__inner">
                                                            <input class="control__field" type="password" name="profile-new-password" id="profile-new-password">
                                                            <label class="control__label" for="profile-new-password">Новый пароль</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="gcell gcell--12 _pt-sm _pb-lg">
                                                    <div class="control control--input">
                                                        <div class="control__inner">
                                                            <input class="control__field" type="password" name="profile-new-password-repeat" id="profile-new-password-repeat">
                                                            <label class="control__label" for="profile-new-password-repeat">Повторите новый пароль</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="gcell gcell--12 _plr-lg" style="border-top: 1px solid #f2f2f2;">
                                            <div class="grid">
                                                <div class="gcell gcell--12 _pt-lg _pb-sm">
                                                    <div class="control control--submit">
                                                        <button class="button button--theme-main button--size-normal button--width-full" type="submit">
                                                            <span class="button__body">
                                                                <span class="button__text">Сохранить</span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="gcell gcell--12 _pb-lg _pt-sm _text-center">
                                                    <a class="link" href="{{ route('site.profile-view') }}">Отмена</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
					</div>
				</div>
			</div>
            <div class="gcell gcell--4 _p-lg _def-show" style="border-left: 1px solid #f2f2f2">
                @include('site._widgets.side-links.side-links')
            </div>
		</div>
	</div>
@endsection
