@php
$image = Html::image($logo, null, [
    'class' => ['logo__image'],
]);
$url = Route::currentRouteName() === 'site.home' ? null : route('site.home');
@endphp
@if($url)
    {!! Html::link(
        Route::currentRouteName() === 'site.home' ? null : route('site.home'),
        $image,
        ['class' => ['logo', $mod_classes ?? '']],
        null,
        false
    ) !!}
@else
    {!! Html::tag(
        'span',
        (string)$image,
        ['class' => ['logo', $mod_classes ?? '']]
    ) !!}
@endif
