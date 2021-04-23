@php
/** @var \App\Components\Menu\Group $menu */
@endphp
<div class="sidebar">
    <div class="sidebar__head">
        <div class="grid _justify-between _items-center">
            <div class="gcell gcell--auto _flex-grow">
                <div class="sidebar__title">Мой аккаунт</div>
            </div>
        </div>
    </div>
    <div class="sidebar__body">
        @foreach($menu->getKids() as $link)
            @include('users::site.widgets.sidebar.sidebar-item', [
                'link' => $link,
            ])
        @endforeach

        @include('users::site.widgets.sidebar.sidebar-item', [
            'link' => new \App\Components\SiteMenu\Link(
                trans('users::site.logout-from-the-site'),
                \App\Core\ObjectValues\LinkObjectValue::make('site.logout'),
                'icon-logout'
            ),
            'mod_class' => 'sidebar-item--logout',
        ])
    </div>
</div>
