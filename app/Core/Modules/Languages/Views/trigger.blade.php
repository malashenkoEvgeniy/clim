@php
/** @var \App\Core\Modules\Languages\Models\Language[]|\Illuminate\Database\Eloquent\Collection $languages */
@endphp
<div class="header-line-item">
    @foreach($languages as $language)
        {!! Html::link($language->current_url_with_new_language, mb_strtoupper($language->slug), [
            'class' => ['header-line-item__link', $language->is_current ? 'header-line-item__link--current' : ''],
        ]) !!}
    @endforeach
</div>
