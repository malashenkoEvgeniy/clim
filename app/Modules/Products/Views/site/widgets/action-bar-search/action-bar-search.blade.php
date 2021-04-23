@php
/** @var string $query */
/** @var string $perPage */
/** @var string $orderBy */
@endphp

<div class="action-bar-search-wrap js-init" data-livesearch data-short-query="Введите минимум 3 символа">
    {!! Form::open(['route' => 'site.search-products', 'method' => 'get', 'class' => 'action-bar-search', 'data-search-form' => true]) !!}
        <input{!! HTML::attributes([
            'type' => 'hidden',
            'name' => 'order',
            'disabled' => !$orderBy,
            'value' => $orderBy,
        ]) !!}>
        <input{!! HTML::attributes([
            'type' => 'hidden',
            'name' => 'per-page',
            'disabled' => !$perPage,
            'value' => $perPage,
        ]) !!}>
        <div class="action-bar-search__group">
            <input type="search" required class="action-bar-search__input"
                    name="query"
                    data-search-input
                    placeholder="Поиск товаров"
                    value="{{ $query }}">
            <button type="submit" class="action-bar-search__submit" title="Поиск товаров">
                {!! SiteHelpers\SvgSpritemap::get('icon-search') !!}
            </button>
        </div>
        <div class="action-bar-search__suggestions" data-search-suggestions></div>
    {!! Form::close() !!}
</div>
