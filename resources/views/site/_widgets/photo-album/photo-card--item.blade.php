@php

@endphp

@if($data)
	<div class="photo-card photo-card--item" data-mfp-src="{{ $data->original }}">
		<div class="photo-card__inner">
			<img class="photo-card__image" src="{{ $data->preview }}">
			<div class="photo-card__body">
				<div class="photo-card__more">
                    {!! SiteHelpers\SvgSpritemap::get('icon-plus') !!}
				</div>
			</div>
		</div>
	</div>
@endif
