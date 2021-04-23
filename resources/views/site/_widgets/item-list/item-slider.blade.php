@php
    // TODO заменить
    $list = [
        config('mock.items')[0],
        config('mock.items')[1],
        config('mock.items')[2],
        config('mock.items')[3],
        config('mock.items')[4],
        config('mock.items')[4]
    ];
    // #end

    $_create_slider = count($list) > 1;
    $_config = !$_create_slider ? [] : [
        'type' => $preset ?? 'SlickItem',
        'user-type-options' => [ ]
    ];
@endphp
<div {!! Html::attributes([
    'class' => [
        'item-slider',
        $mod_class ?? null,
        $_create_slider ? 'js-init' : null
    ]
]) !!} data-slick-slider='{!! json_encode($_config) !!}'>
    <div class="item-slider__list slick-slider-list" data-slick-slider>
        @foreach($list as $item)
            @include('site._widgets.item-card.item-card', [
                'item' => $item
            ])
        @endforeach
    </div>
    @if($_create_slider)
        <div {!! Html::attributes([
            'class' => [
                'item-slider__dots',
                'slick-slider-dots',
                $add_dot_classes ?? null
            ]
        ]) !!} data-slick-dots></div>
    @endif
</div>
