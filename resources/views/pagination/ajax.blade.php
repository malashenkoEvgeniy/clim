@php
/** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator */
/** @var string $url */
@endphp

@if ($paginator->hasPages() && isset($url))
    <div class="separator _color-gray2 _mtb-def"></div>
    <div class="pagination js-init" data-review="{{ $url }}">
        @foreach ($elements as $element)
            @if (is_string($element))
                <div class="pagination__item">{{ $element }}</div>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <div class="pagination__item pagination__item--current">{{ $page }}</div>
                    @else
                        <div class="pagination__item js-pagination-item" data-page="{{ $page }}">{{ $page }}</div>
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>
@endif
