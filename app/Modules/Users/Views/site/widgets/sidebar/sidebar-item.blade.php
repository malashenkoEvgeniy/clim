@php
/** @var \App\Components\SiteMenu\Link $link */
/** @var null|string $mod_class */
@endphp

<a href="{{ $link->getUrl() }}" class="sidebar-item {{ $mod_class ?? '' }} {{ $link->isActive() ? 'is-active' : null }}">
    <div class="grid _hspace-def">
        @if($link->icon)
            <div class="gcell gcell--auto _flex-noshrink _pr-sm">
                <div class="sidebar-item__icon">
                    {!! SiteHelpers\SvgSpritemap::get($link->icon, []) !!}
                </div>
            </div>
        @endif
        <div class="gcell gcell--auto _flex-grow">
            <div class="sidebar-item__title">{{ __($link->name) }}</div>
            @if($link->description)
                <div class="sidebar-item__desc">{{ $link->description }}</div>
            @endif
        </div>
    </div>
</a>
