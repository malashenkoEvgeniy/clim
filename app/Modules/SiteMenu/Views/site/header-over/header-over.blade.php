@php
/** @var \App\Components\SiteMenu\Group $menu */
@endphp
<div class="header-over">
    <div class="header-over__right">
        {!! Widget::show('languages::trigger') !!}
        {!! Widget::show('header-auth-link') !!}
    </div>
    <div class="header-over__left">
        <div class="header-line">
            <div class="header-line__list">
                @foreach($menu->getKids() as $element)
                    @include('site_menu::site.header-menu-element', ['element' => $element])
                @endforeach
            </div>
        </div>
    </div>
</div>
