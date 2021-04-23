<div class="pager {{ $mod_classes ?? '' }}">
    <div class="grid _items-center">
        <div class="gcell gcell--auto">
            <div class="pager__info">1 - 10 из 10</div>
        </div>
        <div class="gcell gcell--auto">
            <a class="pager__control pager__control--prev is-disabled" title="Предыдущие 10 записей">
                {!! SiteHelpers\SvgSpritemap::get('icon-arrow-left-thin', [
                    'class' => 'pager__icon',
                ]) !!}
            </a>
        </div>
        <div class="gcell gcell--auto">
            <a href="#next-10" class="pager__control pager__control--next" title="Следующие 10 записей">
                {!! SiteHelpers\SvgSpritemap::get('icon-arrow-right-thin', [
                    'class' => 'pager__icon',
                ]) !!}
            </a>
        </div>
    </div>
</div>
