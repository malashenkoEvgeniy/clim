<div class="sidebar">
    <div class="sidebar__head">
        <div class="grid _justify-between _items-center">
            <div class="gcell gcell--auto _flex-grow">
                <div class="sidebar__title">Мой аккаунт</div>
            </div>
            {{--<div class="gcell gcell--auto _flex-noshrink">
                <div class="sidebar__beacon has-info">
                    {!! SiteHelpers\SvgSpritemap::get('icon-bell', []) !!}
                </div>
            </div>--}}
        </div>
    </div>
    <div class="sidebar__body">
        @foreach(config('mock.account')->sidebar_items as $item)
            @include('site._widgets.sidebar.sidebar-item', [
                'data' => $item,
            ])
        @endforeach

        @include('site._widgets.sidebar.sidebar-item', [
            'data' => (object) [
                'href' => 'index',
                'icon' => 'icon-logout',
                'name' => 'Выйти',
            ],
            'mod_class' => 'sidebar-item--logout',
        ])
    </div>
</div>
