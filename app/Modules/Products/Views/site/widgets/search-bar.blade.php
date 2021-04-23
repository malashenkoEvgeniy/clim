@php
/** @var string $query */
/** @var string $perPage */
/** @var string $orderBy */
@endphp

<div class="action-bar__wide _bgcolor-white">
    @include('products::site.widgets.action-bar-search.action-bar-search', [
        'query' => $query,
        'perPage' => $perPage,
        'orderBy' => $orderBy,
    ])
</div>
