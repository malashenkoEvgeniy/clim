@php
/** @var array $colors */
@endphp
<style>
	.admin-menu {
		position: fixed;
		top: 50%;
		right: 0;
		z-index: 99;
		width: 46px;
		height: 46px;
		display: flex;
		border-radius: 5px 0 0 5px;
		background: linear-gradient(to left, #343a40 0%, #40484f 100%);
		cursor: pointer;
		outline: none;
	}

	.admin-menu__icon {
		max-width: 60%;
		max-height: 60%;
		fill: #fff;
		margin: auto;
	}

	.admin-panel {
		position: fixed;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		top: 0;
		bottom: 0;
		right: 0;
		width: 240px;
		z-index: 99;
		background: #343a40;
		box-sizing: border-box;
		padding: 10px;
		transition: 0.5s ease-out;
		margin-right: -240px;
	}

	.admin-panel.is-open {
		margin-right: 0;
		box-shadow: -1px 0 10px rgba(0, 0, 0, 0.3);
	}

	.admin-panel__item {
		background: #fff;
		margin-bottom: 7px;
		padding: 10px 10px;
	}

	.admin-panel__title {
		font-size: 13px;
		color: #222;
		padding-bottom: 2px;
		margin-bottom: 4px;
	}
	.admin-panel__input {
		width: 40px;
		height: 20px;
	}
	.admin-panel__control {
		display: flex;
		align-items: center;
	}
	.admin-panel__value {
		padding-left: 10px;
		font-size: 12px;
		color: #333;
	}
</style>

<link rel="stylesheet" href="{{ site_media('static/css/minicolors.css', true) }}">
<script src="{{ site_media('static/js/minicolors.js', true) }}"></script>

<div role="button" tabindex="0" class="admin-menu js-color-open" title="@lang('settings::general.colors.panel')">
	{!! SiteHelpers\SvgSpritemap::get('icon-pallet', [
		'class' => 'admin-menu__icon'
	]) !!}
</div>
{!! Form::open(['method' => 'PUT', 'route' => ['admin.settings.update', 'colors'], 'class' => 'admin-panel js-color-panel']) !!}
	<div>
		@foreach($colors as $color)
			<div class="admin-panel__item">
				<div class="admin-panel__title">{{ array_get($color, 'name') }}</div>
				<div class="admin-panel__control">
					<input class="admin-panel__input" name="{{ array_get($color, 'label') }}" type="text" value="{{ array_get($color, 'value') }}" data-color-label="{{ array_get($color, 'label') }}">
				</div>
			</div>
		@endforeach
		<div class="_text-center">
			<button type="submit" class="button button--theme-main button--size-normal button--width-full">
            <span class="button__body">
                <span class="button__text">@lang('buttons.save')</span>
            </span>
			</button>
		</div>
	</div>
	<div class="_text-center">
		<div class="button button--theme-white button--size-small js-color-close">
            <span class="button__body">
                <span class="button__text">Закрыть</span>
            </span>
		</div>
	</div>
{!! Form::close() !!}
<script>
	window.onload = function (){
		var panel = $('.js-color-panel');

		$('.js-color-open').on('click', function () {
			panel.addClass('is-open');
		});

		$('.js-color-close').on('click', function () {
			panel.removeClass('is-open');
		});

		$('.admin-panel__input').minicolors({
			change: function (value) {
				var label = $(this).data('color-label');

				document.documentElement.style.setProperty(`--color-${label}`, value);
				$(`[data-color-value="${label}"]`).text(value);
			}
		});
	}
</script>
