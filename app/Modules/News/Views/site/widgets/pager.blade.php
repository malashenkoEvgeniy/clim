<div class="pager pager--news pager--centered">
    <div class="grid _justify-center _items-center">
        <div class="gcell gcell--auto">
            <a class="pager__control pager__control--prev is-disabled" title="Предыдущая">
                {!! SiteHelpers\SvgSpritemap::get('icon-arrow-left-thin', [
                    'class' => 'pager__icon',
                ]) !!}
            </a>
        </div>
        <div class="gcell gcell--auto">
            <a href="{{ route('site.news') }}" class="pager__control pager__control--back-to-list" title="Вернуться к списку">
                {!! SiteHelpers\SvgSpritemap::get('icon-square-grid', [
                    'class' => 'pager__icon',
                ]) !!}
            </a>
        </div>
        <div class="gcell gcell--auto">
            <a href="#next-10" class="pager__control pager__control--next" title="Следующая">
                {!! SiteHelpers\SvgSpritemap::get('icon-arrow-right-thin', [
                    'class' => 'pager__icon',
                ]) !!}
            </a>
        </div>
    </div>
</div>
