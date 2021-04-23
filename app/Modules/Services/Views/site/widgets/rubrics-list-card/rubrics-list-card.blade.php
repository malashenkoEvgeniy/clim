@php
/** @var \App\Modules\Services\Models\ServicesRubric $serviceRubric */
$image = $serviceRubric->imageTag('small', [
    'width' => 350,
    'height' => 260,
], false, site_media('static/images/placeholders/no-news.png'));
@endphp
<div class="news-card">
    {!! Html::link($serviceRubric->link, $image, ['class' => 'news-card__image'], null, false) !!}
    <div class="news-card__title">
        <a href="{{ $serviceRubric->link }}">{{ $serviceRubric->current->name }}</a>
    </div>
    <div class="news-card__desc">
        {{ $serviceRubric->teaser }}
    </div>
</div>
