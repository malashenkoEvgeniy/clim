@extends('site._layouts.account')

{{-- TODO Убрать и передавать значения с контроллера --}}
@push('viewTitle', 'Рассылки')
{{-- ENDTODO Убрать и передавать значения с контроллера --}}

@section('account-content')
	<div class="account account--profile-edit">
		<div class="grid">
			<div class="gcell gcell--12 gcell--def-8 _p-lg">
				<div class="grid _nm-lg">
					<div class="gcell gcell--12 _pt-lg _plr-lg _pb-lg">
                        @include('site.account._heading', ['title' => 'Рассылки'])
					</div>
                    <div class="gcell gcell--12 _p-none">
                        <div class="form form--password-change">
                            <form>
                                <div class="form__body">
                                    <div class="grid">
                                        <div class="gcell gcell--12 _pt-sm _pb-lg _plr-lg">
                                            <div class="grid _nmtb-def">
                                                <div class="gcell gcell--12 _ptb-sm">
                                                    @component('site._widgets.checker.checker', [
                                                            'attributes' => [
                                                                'type' => 'checkbox',
                                                                'name' => 'personal-data-processing',
                                                                'required' => true,
                                                            ]
                                                        ])
                                                        <div class="title title--size-h4">Новости</div>
                                                        Будьте в курсе всех событий магазина, просматривайте обзоры
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="gcell gcell--12 _pt-sm _pb-lg _plr-lg">
                                            <div class="grid _nmtb-def">
                                                <div class="gcell gcell--12 _ptb-sm">
                                                    @component('site._widgets.checker.checker', [
                                                            'attributes' => [
                                                                'type' => 'checkbox',
                                                                'checked' => 'checked',
                                                                'name' => 'personal-data-processing',
                                                                'required' => true,
                                                            ]
                                                        ])
                                                        <div class="title title--size-h4">Акции</div>
                                                        Периодически мы проводим акции со скидками, которые могут помочь вам
                                                        сэкономить на покупке.
                                                    @endcomponent
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
		</div>
	</div>
@endsection
