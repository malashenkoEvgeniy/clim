<div class="sidebar">
    <div class="sidebar__body">
        @foreach(config('mock.text-links')->list as $item)
            @include('site._widgets.sidebar.sidebar-item', [
                'data' => $item,
            ])
        @endforeach
    </div>
</div>
