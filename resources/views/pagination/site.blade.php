@php
    $next = null;
    $prev = null;
    if($paginator->hasPages()){
        PaginateRoute::hasNextPage($paginator) ? $next = PaginateRoute::nextPageUrl($paginator) : $next = null;
        PaginateRoute::hasPreviousPage() ? $prev = PaginateRoute::previousPageUrl() : $prev = null;
    }
@endphp
@if($next || $prev)
    @push('meta-next-prev')
        @if($next)
            <link rel="next" href="{{$next}}"/>
        @endif
        @if($prev)
            <link rel="prev" href="{{$prev}}"/>
        @endif
    @endpush
@endif
@if ($paginator->hasPages())
    <div class="pagination _mt-xl">
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
                        <a class="pagination__item pagination__item--current">{{ $page }}</a>
                    @else
                        <a href="{{ PaginateRoute::pageUrl($page) }}" class="pagination__item">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>
@endif
