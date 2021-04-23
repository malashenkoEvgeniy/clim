<div class="grid {{ $grid_mod_classes ?? '' }} _nml-def">
    @foreach($list as $item)
        <div class="gcell _pl-def _mb-xl">
            @include('site._widgets.news.news-list-card.news-list-card', ['item' => $item])
        </div>
        @if ($loop->iteration === $limit)
            @break
        @endif
    @endforeach
</div>
