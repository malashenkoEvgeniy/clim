@php
/** @var \App\Modules\Articles\Models\Article[] $articles */
@endphp
<div class="grid{{ (isset($grid_mod_classes) ? ' ' . $grid_mod_classes : '') }} _nml-def">
    @foreach($services as $element)
        <div class="gcell _pl-def _mb-xl">
            @include('services::site.widgets.services-list-card.services-list-card', [
                'service' => $element,
            ])
        </div>
    @endforeach
</div>
