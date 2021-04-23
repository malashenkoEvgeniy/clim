<div class="grid _justify-between _items-center _flex-nowrap">
    <div class="gcell gcell--auto _flex-grow">
        <div class="title title--size-h2">{{ $title }}</div>
    </div>
    <div class="gcell gcell--auto _flex-noshrink _pl-def _def-hide">
        <div class="dropdown dropdown--to-left js-init" data-toggle>
            <div class="dropdown__head" data-toggle-trigger>
                <div class="dropdown__head-svg">{!! SiteHelpers\SvgSpritemap::get('icon-options', []) !!}</div>
            </div>
            <div class="dropdown__body" data-toggle-content>
                {!! Widget::show('user-account-right-sidebar') !!}
            </div>
        </div>
    </div>
</div>
