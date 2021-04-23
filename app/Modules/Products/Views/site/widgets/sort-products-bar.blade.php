@php
/** @var string $orderBy */
/** @var string $perPage */
/** @var string $query */
/** @var bool $asForm */
$parameters = Route::current()->parameters();
$url = route(Route::currentRouteName(), $parameters);
@endphp

<div class="box">
    {!! Form::open(['url' => $url, 'method' => 'get', 'class' => 'grid _justify-between']) !!}
        @include('products::site.widgets.sort-controls.sort-controls', [
            'query' => $query,
            'orderBy' => $orderBy,
            'perPage' => $perPage,
        ])
    {!! Form::close() !!}
</div>