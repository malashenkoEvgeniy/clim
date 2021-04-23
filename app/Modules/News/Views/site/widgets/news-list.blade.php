@php
/** @var \App\Modules\News\Models\News[] $news */
@endphp
<div class="grid{{ (isset($grid_mod_classes) ? ' ' . $grid_mod_classes : '') }} _nml-def">
    @foreach($news as $element)
        <div class="gcell _pl-def _mb-xl">
            @include('news::site.widgets.news-list-card.news-list-card', ['news' => $element])
        </div>
    @endforeach
</div>
