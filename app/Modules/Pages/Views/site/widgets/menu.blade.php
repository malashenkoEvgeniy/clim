<div class="gcell gcell--3 _flex-noshrink _def-show _def-pr-def">
    <div class="sidebar">
        <div class="sidebar__body">
            @foreach($menuItems as $item)
            <a href="{{ $item->current->slug }}" class="sidebar-item {{ $item->current->slug === $current ?  'is-active' : null }} ">
                <div class="grid _hspace-def">
                    <div class="gcell gcell--auto _flex-grow">
                        <div class="sidebar-item__title">{{ $item->current->name }}</div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
