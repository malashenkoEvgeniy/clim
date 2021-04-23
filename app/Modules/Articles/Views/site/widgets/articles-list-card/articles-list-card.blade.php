@php
/** @var \App\Modules\Articles\Models\Article $article */
$image = $article->imageTag('small', [
    'width' => 350,
    'height' => 260,
], false, site_media('static/images/placeholders/no-news.png'));
@endphp
<div class="news-card">
    {!! Html::link($article->link, $image, ['class' => 'news-card__image'], null, false) !!}
    <div class="news-card__title">
        <a href="{{ $article->link }}">{{ $article->current->name }}</a>
    </div>
    <div class="news-card__desc">
        {{ $article->teaser }}
    </div>
    {!! Widget::show('articles::json-ld', $article) !!}
</div>
