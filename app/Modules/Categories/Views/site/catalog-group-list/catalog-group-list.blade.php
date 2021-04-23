@php
/** @var \App\Modules\Categories\Models\Category[] $categories */
@endphp

<div class="grid grid--2 grid--ms-3 grid--def-4 grid--lg-5">
    @foreach($categories as $category)
        <div class="gcell">
            <div class="catalog-group">
                <div class="catalog-group__image">
                    <a href="{{ $category->site_link }}" title="{{ $category->current->name }}">
                        {!! $category->imageTag('small', ['width' => 260, 'height' => 260], false, site_media('static/images/placeholders/no-category.png')) !!}
                    </a>
                </div>
                <div class="catalog-group__title">
                    <div class="title title--size-h3">
                        <a href="{{ $category->site_link }}">
                            {{ $category->current->name }}
                        </a>
                    </div>
                </div>
                <div class="catalog-group__inner">
                    @foreach($category->activeChildren as $index => $childCategory)
                        <div class="catalog-group__item">
                            <a href="{{ $childCategory->site_link }}"
                                    class="catalog-group__link"
                                    title="{{ $childCategory->current->name }}">
                                {{ $childCategory->current->name }}
                            </a>
                        </div>
                        @if($index === 5)
                            <div class="catalog-group__item">
                                <a href="{{ $category->site_link }}" class="catalog-group__link catalog-group__link--all">
                                    @lang('categories::site.show-all')
                                </a>
                            </div>
                            @break
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
