@if($disabled ?? true)
	<div class="checker disabled">
		<input class="checker__input" {!! Html::attributes($attributes ?? []) !!}>
		<i class="checker__icon">
			{!! SiteHelpers\SvgSpritemap::get($icon ?? 'icon-ok', [
				'class' => 'checker__symbol'
			]) !!}
		</i>
		<span class="checker__text">
            {{ $slot }}
        </span>
	</div>
@else
	<input hidden {!! Html::attributes($attributes ?? []) !!}>
	<a href="{{ $href ?? '#' }}" class="checker{{$checked ? ' is-checked' : null }}">
		<i class="checker__icon">
			{!! SiteHelpers\SvgSpritemap::get($icon ?? 'icon-ok', [
				'class' => 'checker__symbol'
			]) !!}
		</i>
		<span class="checker__text">
			@if($checked)
				<!--dg_selected_filter_title:{{ $header }};;dg_selected_filter_name:{{ $filter_name }}-->
 			@endif       
        {{ $slot }}
    </span>
	</a>
@endif
