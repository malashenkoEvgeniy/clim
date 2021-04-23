<div class="tree">
    <div class="tree__level tree__level--1">
        <div class="tree__item tree__item--1">
            {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-left-thin', [
                'class' => 'tree__icon'
            ]) !!}
            <div class="_ellipsis _flex-grow">
                <a {!! Html::attributes([
                    'class' => 'tree__link',
                    'title' => __('categories::site.catalog'),
                    'href' => '/categories'
                ]) !!}>@lang('categories::site.catalog')</a>
            </div>
        </div>
        @include('categories::site.widgets.catalog-tree.items', [
            'categories' => $categories,
            'i' => 2,
        ])
    </div>
</div>
