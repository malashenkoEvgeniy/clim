@php
$url = Route::currentRouteName() === 'site.home' ? null : route('site.home');
@endphp

@if($url)
    {!! Html::link(
        Route::currentRouteName() === 'site.home' ? null : route('site.home'),
        '<div class="logo__text">'.$text.'</div>',
        ['class' => ['logo', $mod_classes ?? '']],
        null,
        false
    ) !!}
@else
    {!! Html::tag(
        'span',
        '<div class="logo__text">'.$text.'</div>',
        ['class' => ['logo', $mod_classes ?? '']]
    ) !!}
@endif
