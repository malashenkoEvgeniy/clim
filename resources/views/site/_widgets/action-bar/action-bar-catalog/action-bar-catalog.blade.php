<div class="action-bar-catalog{{ $expanded ? ' action-bar-catalog--expanded' : '' }}"
    data-action-bar-catalog="{{ $expanded ? 'expanded' : '' }}">
    <div class="action-bar-catalog-head">
        <div class="action-bar-catalog-opener" data-action-bar-opener>
            <div class="action-bar-catalog-opener__icon">
                @include('site._widgets.elements.hamburger.hamburger')
            </div>
            <div class="action-bar-catalog-opener__text">Каталог</div>
        </div>
        <a href="{{ config('mock.nav-links.catalog-group')->href }}"
                class="action-bar-catalog-link">Все рубруки</a>
    </div>
    <div class="action-bar-catalog-body" data-action-bar-body>
        <div class="action-bar-catalog-body__list js-init" data-perfect-scrollbar>
            <div class="action-bar-catalog-list">
                @foreach($list as $item)
                    <a href="{{ $item->href }}">
                        {!! SiteHelpers\SvgSpritemap::get($item->symbol) !!}
                        <span>{{ $item->text_content }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
