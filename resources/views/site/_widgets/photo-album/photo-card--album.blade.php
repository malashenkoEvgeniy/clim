@php

@endphp

@if($data)
	<a href="{{ $data->href }}" class="photo-card photo-card--album">
		<div class="photo-card__inner">
			<img class="photo-card__image" src="{{ asset($data->img) }}" alt="alt">
			<div class="photo-card__body">
				<div class="photo-card__more">
                    {!! SiteHelpers\SvgSpritemap::get('icon-plus') !!}
				</div>
                @if(!empty($data->title))
                    <div class="photo-card__title">{{ $data->title }}</div>
                @endif
			</div>
		</div>
	</a>
@endif
