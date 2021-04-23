@php
    /** @var \App\Modules\News\Models\News[] $news */
@endphp
<div class="section _def-show">
    <div class="container _mtb-lg _def-mtb-xxl">
        <div class="grid grid--auto _justify-between _items-center _pb-def">
            <div class="gcell _mb-def _mr-def">
                <div class="title title--size-h2">@lang('news::site.news')</div>
            </div>
            <div class="gcell _mb-def _self-end">
                @include('site._widgets.elements.goto.goto', [
					'href' => route('site.news'),
					'to' => 'next',
					'text' => trans('news::site.all-news'),
				])
            </div>
        </div>

        @include('news::site.widgets.news-list', [
			'news' => $news,
			'grid_mod_classes' => 'grid--4',
		])
    </div>
</div>
