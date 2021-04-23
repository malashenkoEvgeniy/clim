@php
/** @var \App\Modules\Categories\Models\Category[] $categories */
/** @var bool $expanded */
@endphp
<div class="action-bar-catalog{{ $expanded ? ' action-bar-catalog--expanded' : '' }}"
    data-action-bar-catalog="{{ $expanded ? 'expanded' : '' }}">
    <div class="action-bar-catalog-head">
        <div class="action-bar-catalog-opener" data-action-bar-opener>
            <div class="action-bar-catalog-opener__icon">
                @include('site._widgets.elements.hamburger.hamburger')
            </div>
            <div class="action-bar-catalog-opener__text">@lang('categories::site.catalog')</div>
        </div>
        <a href="{{ route('site.categories') }}" class="action-bar-catalog-link">
            @lang('categories::site.all-categories')
        </a>
    </div>
    <div class="action-bar-catalog-body" data-action-bar-body>
        <div class="action-bar-catalog-body__list js-init" data-perfect-scrollbar>
            <div class="action-bar-catalog-list js-init" data-submenu>
                @foreach($categories as $category)
                    <div class="action-bar-catalog-list__item{{ $category->has_active_children ? ' js-submenu-item' : null }}">
                        <a class="action-bar-catalog-list__link" href="{{ $category->site_link }}">
                            @if($category->symbol)
                                {!! SiteHelpers\SvgSpritemap::get($category->symbol) !!}
                            @endif
                            <span class="action-bar-catalog-list__text">{{ $category->current->name }}</span>
                        </a>
                    </div>
                @endforeach
                <div class="action-bar-catalog-list__item js-submenu-item">
                    <a class="action-bar-catalog-list__link" href="/services">
                        <span class="action-bar-catalog-list__text">Услуги</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
