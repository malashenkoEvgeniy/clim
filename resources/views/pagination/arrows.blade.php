@php
/** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator */
$perPage = $paginator->perPage();
$currentPage = $paginator->currentPage();
$total = $paginator->total();
$minNumberOnPage = ($currentPage - 1) * $perPage + 1;
$maxNumberOnPage = $currentPage * $perPage;
$maxNumberOnPage = $maxNumberOnPage > $total ? $total : $maxNumberOnPage;
@endphp
<div class="pager pager--orders pager--right-aligned">
    <div class="grid _items-center">
        <div class="gcell gcell--auto">
            <div class="pager__info">{{ $minNumberOnPage }} - {{ $maxNumberOnPage }} из {{ $paginator->total() }}</div>
        </div>
        @if ($paginator->onFirstPage())
            <div class="gcell gcell--auto">
                <a class="pager__control pager__control--prev is-disabled" title="@lang('pagination.prev-rows', ['count' => $perPage])">
                    {!! SiteHelpers\SvgSpritemap::get('icon-arrow-left-thin', [
                        'class' => 'pager__icon',
                    ]) !!}
                </a>
            </div>
        @else
            <div class="gcell gcell--auto">
                <a href="{{ PaginateRoute::pageUrl($currentPage - 1) }}" class="pager__control pager__control--next" title="@lang('pagination.prev-rows', ['count' => $perPage])">
                    {!! SiteHelpers\SvgSpritemap::get('icon-arrow-left-thin', [
                        'class' => 'pager__icon',
                    ]) !!}
                </a>
            </div>
        @endif
        @if ($paginator->hasMorePages())
            <div class="gcell gcell--auto">
                <a href="{{ PaginateRoute::pageUrl($currentPage + 1) }}" class="pager__control pager__control--next" title="@lang('pagination.next-rows', ['count' => $perPage])">
                    {!! SiteHelpers\SvgSpritemap::get('icon-arrow-right-thin', [
                        'class' => 'pager__icon',
                    ]) !!}
                </a>
            </div>
        @else
            <div class="gcell gcell--auto">
                <a class="pager__control pager__control--prev is-disabled" title="@lang('pagination.next-rows', ['count' => $perPage])">
                    {!! SiteHelpers\SvgSpritemap::get('icon-arrow-right-thin', [
                         'class' => 'pager__icon',
                    ]) !!}
                </a>
            </div>
        @endif
    </div>
</div>
