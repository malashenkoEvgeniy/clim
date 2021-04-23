@php
    // TODO заменить
    $list = [[], [], [], [], []];
    // #end

    $_create_slider = count($list) > 1;
    $_config = !$_create_slider ? [] : [
        'type' => 'SlickReviews',
        'user-type-options' => []
    ];
@endphp
<div {!! Html::attributes([
    'class' => [
        'reviews-slider',
        $mod_class ?? null,
        $_create_slider ? 'js-init' : null
    ]
]) !!} data-slick-slider='{!! json_encode($_config) !!}'>
    <div class="reviews-slider__list slick-slider-list" data-slick-slider>
        @foreach($list as $i => $item)
            <div class="slick-slider-list__item">
                @if($i % 2)
                    @component('site._widgets.reviews-item.reviews-item', [
                            'mod_class' => 'reviews-item--theme-light reviews-item--align-center',
                            'mod_message_class' => 'reviews-item-message--big',
                            'user_name' => 'Татьяна Иванова',
                            'user_about' => 'частный предприниматель'
                        ])
                        Спасибо «Locotradeпромпостач» за качественную ветеринарную продукцию. Профилактику и лечение
                        животных провожу только с помощью ваших консультаций и препаратов.
                        Да если бы не вы, все мое большое рогатое хозяйство давно бы наверное обанкротилось. Буду
                        надеяться о сотрудничестве в том же духе
                    @endcomponent
                @else
                    @component('site._widgets.reviews-item.reviews-item', [
                            'user_avatar' => 'avatar-76x76.png',
                            'mod_class' => null,
                            'user_name' => 'Юрий Иванов',
                            'user_about' => 'частный предприниматель'
                        ])
                        Спасибо «Locotradeпромпостач» за качественную ветеринарную продукцию. Профилактику и лечение
                        животных провожу только с помощью ваших консультаций и препаратов.
                    @endcomponent
                @endif
            </div>
        @endforeach
    </div>
    @if($_create_slider)
        <div class="reviews-slider__arrows">
            <div class="slick-slider-arrow slick-slider-arrow--prev" data-slick-arrow-prev>
                {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-left-thin') !!}
            </div>
            <div class="slick-slider-arrow slick-slider-arrow--next" data-slick-arrow-next>
                {!! \SiteHelpers\SvgSpritemap::get('icon-arrow-right-thin') !!}
            </div>
        </div>
        <div class="reviews-slider__dots slick-slider-dots" data-slick-dots></div>
    @endif
</div>
<div class="_text-center">
    @include('site._widgets.elements.goto.goto', [
        'mod_class' => '_color-white',
        'href' => '#',
        'to' => 'next',
        'text' => 'Все отзывы'
    ])
</div>
