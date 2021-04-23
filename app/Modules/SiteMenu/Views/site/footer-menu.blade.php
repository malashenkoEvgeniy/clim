@php
/** @var \App\Components\SiteMenu\Group $menu */
@endphp
<div class="gcell _pl-def _lg-pl-lg">
    <div class="title title--size-h4">@lang('site_menu::site.for-clients')</div>
    <div class="_mtb-def">
        @include('site_menu::site.nav-links.nav-links', [
            'menu' => $menu,
        ])
    </div>
</div>