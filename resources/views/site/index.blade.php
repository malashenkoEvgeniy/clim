@extends('site._layouts.main')

@push('expandedCatalog', true)

@section('layout-body')
    <div class="section _mtb-lg">
        <div class="container">
            @include('site._widgets.feature-slider.feature-slider', [
                'list' => [
                    config('mock.features')[0],
                    config('mock.features')[1],
                    config('mock.features')[2],
                    config('mock.features')[3],
                    config('mock.features')[4]
                ],
                'slides_to_show' => 5
            ])
        </div>
    </div>

    <div class="section _mb-lg">
        <div class="container">
            <div class="grid grid--auto _justify-between _items-center _mt-lg _def-mt-xxl _pb-def">
                <div class="gcell _mb-def _mr-def">
                    <div class="title title--size-h2">Спецпредложения</div>
                </div>
                <div class="gcell _mb-def _self-end">
                    @include('site._widgets.elements.goto.goto', [
                        'href' => '#',
                        'to' => 'next',
                        'text' => 'Все Спецпредложения'
                    ])
                </div>
            </div>
            @include('site._widgets.item-list.item-slider')
        </div>
    </div>


    <div class="section _mb-lg">
        <div class="container _mtb-lg _def-mtb-xxl">
            <div class="grid grid--1 _justify-between _nml-xl">
                <div class="gcell gcell--def-6 _pl-xl _def-show">
                    @include('site._widgets.elements.animation.flasks')
                </div>
                <div class="gcell gcell--def-6 _pl-xl _self-center">
                    <div class="inform-block _def-mr-none">
                        {!! SiteHelpers\SvgSpritemap::get('icon-badge-production', [
                            'class' => 'inform-block__icon'
                        ]) !!}
                        <div class="inform-block__title">
                            <div class="title title--size-h1">Собственное производство</div>
                        </div>
                        <div class="inform-block__content">
                            <div class="wysiwyg">
                                <p>Мощная научно-исследовательская база и собственное современное производство
                                    ветеринарных
                                    препаратов, кормов и кормовых добавок из высококачественного сырья известных брендов
                                    гарантируют выпуск качественного и безопасного продукта.</p>
                                <p>Технологи производства соответствуют требованиям GMP и GMP +, системе управления
                                    качеством
                                    по требованиям ДСТУ ISO 9001, ISO 22000</p>
                            </div>
                        </div>
                        <div class="inform-block__stats">
                            <div class="grid grid--2 _nml-xs">
                                <div class="gcell _pl-xs _mb-def _xxs-mb-none">
                                    <div class="stats">
                                        <div class="stats__value">> 26 000</div>
                                        <div class="stats__desc">тонн премиксов в год</div>
                                    </div>
                                </div>
                                <div class="gcell _pl-xs _mb-def _xxs-mb-none">
                                    <div class="stats">
                                        <div class="stats__value">> 100</div>
                                        <div class="stats__desc">ветпрепаратов в портфеле</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="section _mb-lg">
        <div class="container">
            <div class="grid grid--auto _justify-between _items-center _mt-lg _def-mt-xxl _pb-def">
                <div class="gcell _mb-def _mr-def">
                    <div class="title title--size-h2">Хиты продаж</div>
                </div>
                <div class="gcell _mb-def _self-end">
                    @include('site._widgets.elements.goto.goto', [
                        'href' => '#',
                        'to' => 'next',
                        'text' => 'Все Хиты продаж'
                    ])
                </div>
            </div>
            @include('site._widgets.item-list.item-slider')
        </div>
    </div>


    <div class="section _mb-lg">
        <div class="container _mtb-lg _def-mtb-xxl">
            <div class="grid grid--1 _justify-between _nml-xl _flex-row-reverse">

                <div class="gcell gcell--def-6 _pl-xl _def-show">
                    <div class="_text-center">
                        <style>
                            [data-particle] {
                                position: relative;
                            }

                            [data-particle-source] {
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                opacity: 0;
                            }

                            [data-particle-canvas] {
                                display: block;
                                width: 100%;
                                height: auto;
                            }
                        </style>
                        <div class="js-init" data-particle>
                            <img data-particle-source src="{{ site_media('temp/bull.png') }}" alt="">
                            <canvas data-particle-canvas width="670" height="670"></canvas>
                        </div>
                    </div>
                </div>
                <div class="gcell gcell--def-6 _pl-xl _self-center">
                    <div class="inform-block _def-ml-none">
                        {!! SiteHelpers\SvgSpritemap::get('icon-badge-cow', [
                            'class' => 'inform-block__icon'
                        ]) !!}
                        <div class="inform-block__title">
                            <div class="title title--size-h1">Здоровые животные - <br>
                                здоровая нация
                            </div>
                        </div>
                        <div class="inform-block__content">
                            <div class="wysiwyg">
                                <p>Философия предприятия понятна и жизнеутверждающая: «Здоровые животные - здоровая
                                    нация». Уже больше 20 лет мы заботимся о здоровье нации, выпуская качественную,
                                    экологически безопасную продукцию для поддержания здоровья продуктивных и домашних
                                    животных.</p>

                                <p>Высококвалифицированные специалисты «Locotradeпромпостач» осуществляют научное
                                    сопровождение продукции, оказывая квалифицированную помощь владельцам животных по
                                    технологиям содержания и кормления, профилактике и лечению животных в более чем в 30
                                    филиалах по всей стране и за рубежом.</p>
                            </div>
                        </div>
                        <div class="inform-block__stats">
                            <div class="grid _nml-xs">
                                <div class="gcell gcell--6 _pl-xs">
                                    <div class="stats"><div class="stats__value">> 1 800</div>
                                        <div class="stats__desc">консультаций в день</div>
                                    </div>
                                </div>
                                <div class="gcell gcell--6 _pl-xs">
                                    <div class="stats">
                                        <div class="stats__value">> 15 000</div>
                                        <div class="stats__desc">хозяйств-партнеров</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="section _mb-lg">
        <div class="container">
            <div class="grid grid--auto _justify-between _items-center _mt-lg _def-mt-xxl _pb-def">
                <div class="gcell _mb-def _mr-def">
                    <div class="title title--size-h2">Новинки</div>
                </div>
                <div class="gcell _mb-def _self-end">
                    @include('site._widgets.elements.goto.goto', [
                        'href' => '#',
                        'to' => 'next',
                        'text' => 'Все Новинки'
                    ])
                </div>
            </div>
            @include('site._widgets.item-list.item-slider')
        </div>
    </div>


    <div class="section _mb-lg">
        <div class="container">
            <div class="_mt-lg _def-mt-xxl _pb-xl _text-center">
                <div class="title title--size-h2">Наши гарантии</div>
            </div>
            @include('site._widgets.feature-slider.feature-slider', [
                'list' => [
                    config('mock.features')[5],
                    config('mock.features')[6],
                    config('mock.features')[7],
                    config('mock.features')[8]
                ],
                'slides_to_show' => 4,
                'split' => true
            ])
        </div>
    </div>



    <div class="section section--invert _mt-lg _def-mt-xxl _pb-xxl _ovh" style="
            background :url({{ site_media('static/images/reviews/bg-01.jpg', true) }}) #888 top center / cover;
            ">
        <div class="container container--def">
            <div class="_mt-lg _def-mt-xxl _pb-xl _text-center">
                <div class="title title--size-h2 title--theme-white">Более 200 отзывов</div>
            </div>
            @include('site._widgets.reviews-slider.reviews-slider', [
                'mod_class' => 'reviews-slider--theme-light'
            ])
        </div>
    </div>


    <div class="section _mb-lg">
        <div class="container">
            <div class="_mt-lg _def-mt-xxl _pb-xl _text-center">
                <div class="title title--size-h2">Наши бренды</div>
            </div>
            @include('site._widgets.brands-slider.brands-slider', [
                'mod_class' => 'reviews-slider--theme-light'
            ])
        </div>
    </div>




    <div class="section _def-show">
        <div class="container _mtb-lg _def-mtb-xxl">

            <div class="grid _nml-xl">
                <div class="gcell gcell--9 _pl-xl">
                    <div class="grid grid--auto _justify-between _items-center _pb-def">
                        <div class="gcell _mb-def _mr-def">
                            <div class="title title--size-h2">Новости</div>
                        </div>
                        <div class="gcell _mb-def _self-end">
                            @include('site._widgets.elements.goto.goto', [
                                'href' => '#',
                                'to' => 'next',
                                'text' => 'Все Новости'
                            ])
                        </div>
                    </div>

                    @include('site._widgets.news.news-list', [
                        'list' => config('mock.news'),
                        'grid_mod_classes' => 'grid--3',
                        'limit' => 3
                    ])
                </div>
                <div class="gcell gcell--3 _pl-xl">
                    <div class="_pb-xl">
                        <div class="title title--size-h2">Наши издания</div>
                    </div>
                    @include('site._widgets.publications.publications')
                </div>
            </div>
        </div>
        {{--<button data-mmenu-opener="mobile-menu">
            mobile-menu
        </button>--}}
    </div>
@endsection
