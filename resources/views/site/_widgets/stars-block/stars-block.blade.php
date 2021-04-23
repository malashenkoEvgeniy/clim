<div class="stars-block stars-block--{{ $mod ?? 'normal' }}">
	<a {!! isset($link) ? sprintf("href=\"%s\"", route($link)) : null !!} class="stars-block__inner" title="{{ $title ?? null }}">
		<svg data-count="{{ $count }}" class="stars-block__svg" viewBox="0 0 75 15">
			<g>
				<use xlink:href="{{ site_media('assets/svg/spritemap.svg#icon-star') }}" x="0"></use>
			</g>
			<g>
				<use xlink:href="{{ site_media('assets/svg/spritemap.svg#icon-star') }}" x="20%"></use>
			</g>
			<g>
				<use xlink:href="{{ site_media('assets/svg/spritemap.svg#icon-star') }}" x="40%"></use>
			</g>
			<g>
				<use xlink:href="{{ site_media('assets/svg/spritemap.svg#icon-star') }}" x="60%"></use>
			</g>
			<g>
				<use xlink:href="{{ site_media('assets/svg/spritemap.svg#icon-star') }}" x="80%"></use>
			</g>
		</svg>
	</a>
</div>
