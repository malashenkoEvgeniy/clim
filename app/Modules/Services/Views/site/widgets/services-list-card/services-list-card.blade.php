@php
    /** @var \App\Modules\Services\Models\Service $service */
    $image = $service->imageTag('small', [
        'width' => 350,
        'height' => 260,
    ], false, site_media('static/images/placeholders/no-news.png'));
@endphp
<div class="news-card">
    {!! Html::link($service->link, $image, ['class' => 'news-card__image'], null, false) !!}
    <div class="news-card__title">
        <a href="{{ $service->link }}">{{ $service->current->name }}</a>
    </div>
    <div class="news-card__desc">
        {{ $service->teaser }}
    </div>
</div>
