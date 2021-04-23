@extends('site._layouts.account')

{{-- TODO Убрать и передавать значения с контроллера --}}
@push('viewTitle', 'Редактироване личных данных')
{{-- ENDTODO Убрать и передавать значения с контроллера --}}

@section('account-content')
	<div class="account account--profile-edit">
		<div class="grid">
			<div class="gcell gcell--12 gcell--def-8 _p-lg">
				<div class="grid _nm-lg">
					<div class="gcell gcell--12 _pt-lg _plr-lg _pb-def">
                        @include('site.account._heading', ['title' => 'Редактирование личных данных'])
					</div>
                    <div class="gcell gcell--12 _p-none">
                        <div class="form form--password-change">
                            <form>
                                <div class="form__body">
                                    <div class="grid">
                                        <div class="gcell gcell--12 _pt-sm _pb-lg _plr-lg">
                                            <div class="grid _nmtb-lg">
                                                <div class="gcell gcell--12 _pt-lg _pb-sm">
                                                    <div class="title title--size-h3">Основные данные</div>
                                                </div>
                                                <div class="gcell gcell--12 _ptb-sm">
                                                    <div class="control control--input has-value">
                                                        <div class="control__inner">
                                                            <input class="control__field" type="text" name="profile-name" id="profile-name" value="Стас Михайлов">
                                                            <label class="control__label" for="profile-name">Имя</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="gcell gcell--12 _ptb-sm">
                                                    <div class="control control--input has-value">
                                                        <div class="control__inner">
                                                            <input class="control__field" type="email" name="profile-email" id="profile-email" value="user@gmail.com">
                                                            <label class="control__label" for="profile-email">Эл. почта</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="gcell gcell--12 _ptb-sm">
                                                    <div class="hint">Телефон</div>
                                                    <div>+380 (99) 982-32-05</div>
                                                    <a href="{{ route('site.profile-phone-change') }}" class="link link--sm">Изменить</a>
                                                </div>
                                                <div class="gcell gcell--12 _ptb-sm">
                                                    <div class="hint _mb-sm">Дата рождения</div>
                                                    <div class="grid _nmlr-sm">
                                                        <div class="gcell gcell--3 _plr-sm">
                                                            <div class="control control--input">
                                                                <div class="control__inner">
                                                                    <input class="control__field" type="tel" name="profile-birthday-day" id="profile-birthday-day">
                                                                    <label class="control__label" for="profile-birthday-day">Дом</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="gcell gcell--6 _plr-sm">
                                                            <div class="control control--select">
                                                                <select class="control__field" name="profile-birthday-month" id="profile-birthday-month" onchange="this.blur()">
                                                                    <option value="" selected="" disabled="">Месяц</option>
                                                                    <option value="06">Июнь</option>
                                                                    <option value="07">Июль</option>
                                                                    <option value="08">Август</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="gcell gcell--3 _plr-sm">
                                                            <div class="control control--input">
                                                                <div class="control__inner">
                                                                    <input class="control__field" type="tel" name="profile-birthday-year" id="profile-birthday-year">
                                                                    <label class="control__label" for="profile-birthday-year">Дом</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="gcell gcell--12 _ptb-sm">
                                                    <div class="control control--select">
                                                        <select class="control__field" name="profile-gender" id="profile-gender" onchange="this.blur()">
                                                            <option value="" selected="" disabled="">Выберите пол</option>
                                                            <option value="female">Женский</option>
                                                            <option value="male">Мужской</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="gcell gcell--12 _pt-sm _pb-lg">
                                                    <div class="title title--size-h3 _mb-sm">Адрес доставки</div>
                                                    <div class="control control--select _ptb-sm">
                                                        <select class="control__field"  name="profile-delivery-city" id="profile-delivery-city" onchange="this.blur()">
                                                            <option value="" selected="" disabled="">Выберите свой город</option>
                                                            <option value="1">Киев</option>
                                                            <option value="2">Днепропетровск</option>
                                                            <option value="3">Херсон</option>
                                                        </select>
                                                    </div>
                                                    <div class="grid _ptb-sm _nmlr-sm">
                                                        <div class="gcell gcell--6 _plr-sm">
                                                            <div class="control control--input">
                                                                <div class="control__inner">
                                                                    <input class="control__field" type="text" name="profile-delivery-street" id="profile-delivery-street">
                                                                    <label class="control__label" for="profile-delivery-street">Улица</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="gcell gcell--3 _plr-sm">
                                                            <div class="control control--input">
                                                                <div class="control__inner">
                                                                    <input class="control__field" type="tel" name="profile-delivery-street" id="profile-delivery-street">
                                                                    <label class="control__label" for="profile-delivery-street">Дом</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="gcell gcell--3 _plr-sm">
                                                            <div class="control control--input">
                                                                <div class="control__inner">
                                                                    <input class="control__field" type="tel" name="profile-delivery-house-number" id="profile-delivery-house-number">
                                                                    <label class="control__label" for="profile-delivery-house-number">Кв.</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="control control--textarea _pt-sm">
                                                        <div class="control__inner">
                                                            <textarea class="control__field" name="profile-delivery-extras" id="profile-delivery-extras"></textarea>
                                                            <label class="control__label" for="profile-delivery-extras">Район, лифт, этаж, домофон</label>
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
