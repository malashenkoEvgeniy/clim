@php
    $is_active = Route::currentRouteName() === $data->href ? 'is-active' : null;
	$href = sprintf("href=\"%s\"", Route::has($data->href) ? route($data->href) : $data->href);
@endphp

<a {!! $is_active ? null : $href !!} class="sidebar-item {{ $mod_class ?? '' }} {{ $is_active }}">
    <div class="grid _hspace-def">
        @if(!empty($data->icon))
            <div class="gcell gcell--auto _flex-noshrink _pr-sm">
                <div class="sidebar-item__icon">
                    {!! SiteHelpers\SvgSpritemap::get($data->icon, []) !!}
                </div>
            </div>
        @endif
        <div class="gcell gcell--auto _flex-grow">
            <div class="sidebar-item__title">{{ $data->name }}</div>
            @if(!empty($data->desc))
                <div class="sidebar-item__desc">{{ $data->desc }}</div>
            @endif
        </div>
    </div>
</a>
