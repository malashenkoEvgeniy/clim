@php
/** @var string $currentCategorySlug */
/** @var \App\Modules\Categories\Models\Category[]|\Illuminate\Database\Eloquent\Collection $categories */
@endphp

@component('products::site.widgets.accordion.accordion', [
    'options' => [
        'type' => 'multiple',
    ],
])
    <hr class="separator _color-gray2 _mtb-def _hide-last _hide-mobile _def-show">
    @component('products::site.widgets.filter-accordion.accordion-block', [
        'ns' => 'filter',
        'id' => 0,
        'header' => __('categories::site.catalog'),
        'open' => true,
    ])
        <ul class="nav-links{{ (isset($list_mod_classes) ? ' ' . $list_mod_classes : '') }}">
            @foreach($categories as $category)
                <li class="nav-links__item">
                    @if($category->current->slug === $currentCategorySlug)
                        <span class="nav-links__link is-disabled">{{ $category->current->name }}</span>
                    @else
                        <a class="nav-links__link" href="{{ $category->site_link }}">{{ $category->current->name }}</a>
                    @endif
                </li>
            @endforeach
        </ul>
    @endcomponent
@endcomponent
