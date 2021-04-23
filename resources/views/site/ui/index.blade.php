@extends('site._layouts.main')

@section('layout-body')
    <div class="section">
        <div class="container">
            <div class="_ptb-lg">
                <div class="title title--size-h3">Быстрая навигация</div>
                <ol class="__demo-nav _columns-def-3">
                    <li><a class="link" href="#network-links">Ссылки на соц. сети</a></li>
                    <li><a class="link" href="#buttons">Пример кнопок</a></li>
                    <li><a class="link" href="#item-card">Карточка товара в списке</a></li>
                    <li><a class="link" href="#news-cards">Список новостей</a></li>
                    <li><a class="link" href="#reviews">Отзывы</a></li>
                    <li><a class="link" href="#spritemap-print">SVG Spritemap</a></li>
                    {{--<li><a class="link" href="#wysiwyg-example">Типография</a></li>--}}
                </ol>
                @push('head-styles')
                    <style>
                        .layout__body {
                            counter-reset: count;
                        }

                        :target {
                            padding-top: 115px !important;
                        }

                        .__count::before {
                            counter-increment: count;
                            content: counter(count) '. ';
                        }

                        .__demo-nav {
                            list-style: none;
                            padding: 0;
                            counter-reset: demo-nav;
                            max-width: 720px;
                        }

                        .__demo-nav li {
                            margin-bottom: 6px;
                        }

                        .__demo-nav li::before {
                            counter-increment: demo-nav;
                            content: counter(demo-nav) '. ';
                        }
                    </style>
                @endpush
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <hr>
            <div class="_ptb-lg" id="network-links">
                <div class="title title--size-h3 __count">Ссылки на соц. сети</div>
                @foreach(config('mock.network-links') as $network => $item)
                    @include('site._widgets.elements.network-link.network-link', ['network' => $network, 'item' => $item])
                @endforeach
            </div>
        </div>

        <div class="container">
            <hr>
            <div class="_ptb-lg" id="buttons">
                <div class="title title--size-h3 __count">Пример кнопок</div>
                <div class="_mb-sm">
                    @include('site._widgets.elements.button.buttons-example')
                </div>
                <div class="title title--size-h4">Готовые кнопки</div>
                <div class="_mb-sm">
                    @include('site._widgets.elements.button.request-call')
                </div>
            </div>
        </div>

        <div class="container">
            <hr>
            <div class="_ptb-lg" id="item-card">
                <div class="title title--size-h3 __count">Карточка товара в списке</div>
                <div style="max-width: 300px;">
                    @include('site._widgets.item-card.item-card', [
                        'item' => config('mock.items')[0]
                    ])
                </div>
            </div>
        </div>

        <div class="container">
            <hr>
            <div class="_ptb-lg" id="news-cards">
                <div class="title title--size-h3 __count">Список новостей</div>
                @include('site._widgets.news.news-list', [
                    'title' => 'Новости',
                    'all_news_href' => '#',
                    'all_news_title' => 'Все новости',
                    'list' => config('mock.news'),
                    'grid_mod_classes' => 'grid--4',
                    'limit' => 0
                ])
            </div>
        </div>

        <div class="container">
            <hr>

            <div class="_ptb-lg" id="reviews">
                <div class="title title--size-h3 __count">Отзывы</div>

                <div class="_mtb-lg" style="max-width: 840px;">
                    @component('site._widgets.reviews-item.reviews-item', [
                        'user_name' => 'Юрий Иванов',
                        'user_about' => 'частный предприниматель'
                    ])
                        Спасибо «Locotradeпромпостач» за качественную ветеринарную продукцию. Профилактику и лечение
                        животных провожу только с помощью ваших консультаций и препаратов.
                    @endcomponent

                    @component('site._widgets.reviews-item.reviews-item', [
                        'user_avatar' => 'avatar-76x76.png',
                        'mod_class' => 'reviews-item--align-center',
                        'user_name' => 'Юрий Иванов',
                        'user_about' => 'частный предприниматель'
                    ])
                        Спасибо «Locotradeпромпостач» за качественную ветеринарную продукцию. Профилактику и лечение
                        животных провожу только с помощью ваших консультаций и препаратов.
                    @endcomponent

                    <div class="_p-def _bgcolor-gray7 _mb-md">
                        @component('site._widgets.reviews-item.reviews-item', [
                            'user_avatar' => 'avatar-76x76.png',
                                'mod_class' => 'reviews-item--theme-light reviews-item--align-center',
                            'user_name' => 'Юрий Иванов',
                            'user_about' => 'частный предприниматель'
                        ])
                            Спасибо «Locotradeпромпостач» за качественную ветеринарную продукцию. Профилактику и лечение
                            животных провожу только с помощью ваших консультаций и препаратов.
                        @endcomponent
                    </div>
                        <div class="_p-def _bgcolor-gray7">
                            @component('site._widgets.reviews-item.reviews-item', [
                                'user_avatar' => 'avatar-76x76.png',
                                 'mod_class' => 'reviews-item--theme-light reviews-item--align-center',
                                'mod_message_class' => 'reviews-item-message--big',
                                'user_name' => 'Юрий Иванов',
                                'user_about' => 'частный предприниматель'
                            ])
                                Спасибо «Locotradeпромпостач» за качественную ветеринарную продукцию. Профилактику и
                                лечение
                                животных провожу только с помощью ваших консультаций и препаратов.
                            @endcomponent
                        </div>
                </div>

            </div>
        </div>

        <div class="container">
            <hr>

            <div class="_ptb-lg" id="spritemap-print">
                <div class="title title--size-h3 __count">SVG Spritemap</div>
                @include('site._widgets.svg.spritemap-print')
            </div>
        </div>
    </div>
@endsection
