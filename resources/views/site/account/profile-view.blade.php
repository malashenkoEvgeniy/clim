@extends('site._layouts.account')

{{-- TODO Убрать и передавать значения с контроллера --}}
@push('viewTitle', 'Личные данные')
{{-- ENDTODO Убрать и передавать значения с контроллера --}}

@section('account-content')
	<div class="account account--profile-view">
		<div class="grid">
			<div class="gcell gcell--12 gcell--def-8 _p-lg">
				<div class="grid _nm-lg">
					<div class="gcell gcell--12 _pt-lg _plr-lg _pb-def">
						@include('site.account._heading', ['title' => 'Личные данные'])
					</div>
					{{--<div class="gcell gcell--12 _ptb-sm _plr-lg">
                        @component('site._widgets.alert.alert', [
                            'alert_type' => 'secondary',
                            'alert_icon' => 'icon-warn',
                        ])
                            <div>Вы не подтвердили свою почту:</div>
                            <div><strong>user@gmail.com</strong></div>

                            @slot('alert_button')
                                <button class="button button--theme-main button--size-normal alert__button">
                                    <span class="button__body">
                                        <span class="button__text">Подтвердить</span>
                                    </span>
                                </button>
                            @endslot
                        @endcomponent
					</div>--}}
					<div class="gcell gcell--12 _pb-lg _plr-lg _pt-def" style="border-bottom: 1px solid #f2f2f2;">
                        <div class="grid">
                            @foreach(config('mock.account')->user_info as $user)
                                <div class="gcell gcell--12 _ptb-sm _sm-ptb-none">
                                    <div class="grid _items-center _nmlr-xs">
                                        <div class="gcell gcell--12 gcell--sm-4 _sm-ptb-sm _plr-xs">
                                            <div class="_color-gray4" style="font-size: 1rem;">{{ $user->label }}:</div>
                                        </div>
                                        <div class="gcell gcell--12 gcell--sm-8 _sm-ptb-sm _plr-xs">
                                            <div class="_color-gray8">{{ $user->value }}</div>
                                            {{--@if($user->type === 'phone' && !$user->is_confirmed)
                                                <div><a class="link link--sm">Подтвердить номер</a></div>
                                            @endif--}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
