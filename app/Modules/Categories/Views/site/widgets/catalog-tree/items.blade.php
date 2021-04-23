<?php
/**
 * @var int $i
 * @var \App\Modules\Categories\Models\Category[]|\Illuminate\Support\Collection $categories
 */
$category = $categories->isNotEmpty() ? $categories->shift() : null;
$hasNext = $category && $categories->isNotEmpty();
?>
@if($category)
    <div class="tree__level tree__level--{{ $i }}">
        <div class="tree__item tree__item--{{ $i }}">
            {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-left-thin', [
                'class' => 'tree__icon'
            ]) !!}
            <div class="_ellipsis _flex-grow">
                <a {!! Html::attributes([
                    'class' => 'tree__link',
                    'title' => $category->current->name,
                    'href' => $hasNext ? $category->site_link : null,
                ]) !!}>{{ $category->current->name }}</a>
            </div>
        </div>
        @if($hasNext)
            @include('categories::site.widgets.catalog-tree.items', [
                'categories' => $categories,
                'i' => $i + 1,
            ])
        @endif
    </div>
@endif
