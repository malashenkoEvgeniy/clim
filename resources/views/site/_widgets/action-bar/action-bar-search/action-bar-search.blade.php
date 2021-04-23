<form class="action-bar-search" action="/html/search">
    <input{!! HTML::attributes([
        'type' => 'hidden',
        'name' => 'sort',
        'disabled' => isset($sort) ? null : true,
        'value' => $sort ?? null, // Указать value если есть значение в запросе
    ]) !!}>
    <input{!! HTML::attributes([
        'type' => 'hidden',
        'name' => 'show',
        'disabled' => isset($show) ? null : true,
        'value' => $show ?? null, // Указать value если есть значение в запросе
    ]) !!}>
    <div class="action-bar-search__group">
        <input type="search" required class="action-bar-search__input"
                name="query"
                placeholder="Поиск товаров">
        <button type="submit" class="action-bar-search__submit" title="Поиск товаров">
            {!! SiteHelpers\SvgSpritemap::get('icon-search') !!}
        </button>
    </div>
</form>
