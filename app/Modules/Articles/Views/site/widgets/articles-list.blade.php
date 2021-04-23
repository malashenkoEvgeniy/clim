@php
/** @var \App\Modules\Articles\Models\Article[] $articles */
@endphp
<div class="grid{{ (isset($grid_mod_classes) ? ' ' . $grid_mod_classes : '') }} _nml-def">
    @foreach($articles as $element)
        <div class="gcell _pl-def _mb-xl">
            @include('articles::site.widgets.articles-list-card.articles-list-card', [
                'article' => $element,
            ])
        </div>
    @endforeach
</div>
