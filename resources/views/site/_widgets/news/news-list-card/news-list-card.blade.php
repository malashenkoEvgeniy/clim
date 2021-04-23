@php
    $news_view_href = Route::has($item->href) ? route($item->href) : $item->href
@endphp

<div class="news-card">
    <a href="{{ $news_view_href }}" class="news-card__image">
        <img src="{{ site_media('temp/news-card/' . $item->image, true) }}"
            width="350" height="260" alt="{{ $item->title }}">
    </a>
    <time class="news-card__datetime" datetime="{{ $item->datetime_iso }}">
        {{ $item->datetime_formatted }}
    </time>
    <div class="news-card__title">
        <a href="{{ $news_view_href }}">{{ $item->title }}</a>
    </div>
    <div class="news-card__desc">
        {{ strip_tags($item->teaser) }}
    </div>
</div>
