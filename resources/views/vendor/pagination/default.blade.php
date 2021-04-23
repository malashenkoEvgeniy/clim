@if ($paginator->hasPages())
	<ul class="pagination">
		{{-- Previous Page Link --}}
		@if ($paginator->onFirstPage())
			<li class="is-disabled"><span>Назад</span></li>
		@else
			<li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">Назад</a></li>
		@endif
		<li class="decor"></li>
		{{-- Pagination Elements --}}
		@foreach ($elements as $element)
			{{-- "Three Dots" Separator --}}
			@if (is_string($element))
				<li class="is-disabled"><span>{{ $element }}</span></li>
			@endif

			{{-- Array Of Links --}}
			@if (is_array($element))
				@foreach ($element as $page => $url)
					@if ($page == $paginator->currentPage())
						<li class="is-active"><span>{{ $page }}</span></li>
					@else
						<li><a href="{{ $url }}">{{ $page }}</a></li>
					@endif
				@endforeach
			@endif
		@endforeach
		<li class="decor"></li>
		{{-- Next Page Link --}}
		@if ($paginator->hasMorePages())
			<li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Дальше</a></li>
		@else
			<li class="is-disabled"><span>Дальше</span></li>
		@endif
	</ul>
@endif
