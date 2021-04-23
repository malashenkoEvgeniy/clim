<div class="news-card">
	<a href="{{ $news->link }}" class="news-card__image">
        {!! Widget::show('image', $news->image, 'small', ['class' => 'item-card-preview__image']) !!}
	</a>
	<time class="news-card__datetime" datetime="{{ $news->published_at->format('Y-m-d') }}">
		{{ $news->formatted_published_at }}
	</time>
	<div class="news-card__title">
		<a href="{{ $news->link }}">{{ $news->current->name }}</a>
	</div>
	<div class="news-card__desc">
		{{ $news->teaser }}
	</div>
	{!! Widget::show('news::json-ld', $news) !!}
</div>
