@extends('site._layouts.main')

@section('layout-body')
    <div class="section _mb-lg">
        <div class="container">
            <div class="box">
                <div class="title title--size-h1">
                    Противопаразитарные препараты
                </div>
            </div>
            <form class="grid grid--1" id="filter">
                <div class="gcell gcell--def-3 gcell--lg-1-of-5">
                    <div class="box">
                        <div class="_def-show">
                            @include('site._widgets.tree.tree', [
                                'list' => [
                                    (object)[
                                        'href' => '#',
                                        'text_content' => 'Каталог'
                                    ],
                                    (object)[
                                        'href' => '#',
                                        'text_content' => 'Ветеринарные препараты'
                                    ],
                                    (object)[
                                        'href' => '#',
                                        'text_content' => 'Противопаразитарные препараты'
                                    ]
                                ]
                            ])
                            <hr class="separator _color-gray2 _mtb-def _hide-last _hide-mobile _def-show">
                            @component('site._widgets.accordion.accordion', [
                                'options' => [
                                    'type' => 'multiple'
                                ]
                            ])
                                @php
                                	$_accordionBlockNs = 'filter';
                                	$_accordionBlockId = 1;
                                @endphp
                                @component('site._widgets.accordion.accordion-block', [
                                    'ns' => $_accordionBlockNs,
                                    'id' => $_accordionBlockId++,
                                    'header' => 'Категории',
                                    'open' => true
                                ])
                                    @include('site._widgets.elements.nav-links.nav-links', [
                                        'list' => [
                                            (object)[
                                                'href' => '#',
                                                'text_content' => 'Противопаразитарные'
                                            ],
                                            (object)[
                                                'href' => '#',
                                                'text_content' => 'Антимикробные'
                                            ],
                                            (object)[
                                                'href' => '#',
                                                'text_content' => 'Противовоспалительные'
                                            ],
                                            (object)[
                                                'href' => '#',
                                                'text_content' => 'Противомаститные'
                                            ],
                                            (object)[
                                                'href' => '#',
                                                'text_content' => 'Репродуктивные'
                                            ],
                                            (object)[
                                                'href' => '#',
                                                'text_content' => 'Дерматологические'
                                            ],
                                            (object)[
                                                'href' => '#',
                                                'text_content' => 'Витаминные'
                                            ]
                                        ]
                                    ])
                                @endcomponent
                                <hr class="separator _color-gray2 _mtb-def _hide-last">





                                @component('site._widgets.accordion.accordion-block', [
                                    'ns' => $_accordionBlockNs,
                                    'id' => $_accordionBlockId++,
                                    'header' => 'Животные',
                                    'open' => true
                                ])
                                    <div class="grid grid--5 _nmr-sm">
                                        @for($i = 0; $i < 7; $i++)
                                            <div class="gcell _pr-sm _mb-sm">
                                                <label class="animal-checker">
                                                    <input type="checkbox" name="animal" value="{{ $i }}">
                                                    <span>
                                                        {!! \SiteHelpers\SvgSpritemap::get('icon-animal-' . ($i + 1)) !!}
                                                    </span>
                                                </label>
                                            </div>
                                        @endfor
                                    </div>
                                @endcomponent
                                <hr class="separator _color-gray2 _mtb-def _hide-last">





                                @component('site._widgets.accordion.accordion-block', [
                                    'ns' => $_accordionBlockNs,
                                    'id' => $_accordionBlockId++,
                                    'header' => 'Цена, грн.',
                                    'open' => true
                                ])
                                    <div class="js-init" data-ion-range>
                                        <div class="grid _nml-sm">
                                            <div class="gcell gcell--4-of-5 _pl-sm">
                                                <div class="grid _nml-sm">
                                                    <div class="gcell gcell--6 _pl-sm">
                                                        <div class="range-input">
                                                            <input type="text"text
                                                                    class="range-input__value"
                                                                    size="1"
                                                                    value="90"
                                                                    name="price-min"
                                                                    data-ion-min-value>
                                                            <div class="range-input__label">от</div>
                                                        </div>
                                                    </div>
                                                    <div class="gcell gcell--6 _pl-sm">
                                                        <div class="range-input">
                                                            <input type="text"
                                                                    class="range-input__value"
                                                                    size="1"
                                                                    value="12000"
                                                                    name="price-max"
                                                                    data-ion-max-value>
                                                            <div class="range-input__label">до</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="gcell gcell--1-of-5 _pl-sm">
                                                <button type="submit" class="range-button">OK</button>
                                            </div>
                                        </div>
                                    </div>
                                @endcomponent
                                <hr class="separator _color-gray2 _mtb-def _hide-last">





                                @component('site._widgets.accordion.accordion-block', [
                                    'ns' => $_accordionBlockNs,
                                    'id' => $_accordionBlockId++,
                                    'header' => 'Действующее вещество',
                                    'open' => true
                                ])
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'checked' => true,
                                                'value' => 1
                                            ]
                                        ])
                                            Хондроитин
                                        @endcomponent
                                    </div>
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'value' => 2
                                            ]
                                        ])
                                            Лецитин
                                        @endcomponent
                                    </div>
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'value' => 3
                                            ]
                                        ])
                                            Экстракт артишока
                                        @endcomponent
                                    </div>
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'value' => 4
                                            ]
                                        ])
                                            Тиотриазолин
                                        @endcomponent
                                    </div>
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'value' => 1
                                            ]
                                        ])
                                            Хондроитин
                                        @endcomponent
                                    </div>
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'checked' => true,
                                                'value' => 2
                                            ]
                                        ])
                                            Лецитин
                                        @endcomponent
                                    </div>
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'value' => 3
                                            ]
                                        ])
                                            Экстракт артишока
                                        @endcomponent
                                    </div>
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'value' => 4
                                            ]
                                        ])
                                            Тиотриазолин
                                        @endcomponent
                                    </div>
                                @endcomponent
                                <hr class="separator _color-gray2 _mtb-def _hide-last">





                                @component('site._widgets.accordion.accordion-block', [
                                    'ns' => $_accordionBlockNs,
                                    'id' => $_accordionBlockId++,
                                    'header' => 'Бренд',
                                    'open' => true
                                ])
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'checked' => true,
                                                'value' => 1
                                            ]
                                        ])
                                            Эко-Био
                                        @endcomponent
                                    </div>
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'value' => 2
                                            ]
                                        ])
                                            Эко-Био
                                        @endcomponent
                                    </div>
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'value' => 3
                                            ]
                                        ])
                                            Экстракт артишока
                                        @endcomponent
                                    </div>
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'value' => 4
                                            ]
                                        ])
                                            Зоохелс
                                        @endcomponent
                                    </div>
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'value' => 1
                                            ]
                                        ])
                                            Плахтянские корма
                                        @endcomponent
                                    </div>
                                @endcomponent
                                <hr class="separator _color-gray2 _mtb-def _hide-last">





                                @component('site._widgets.accordion.accordion-block', [
                                    'ns' => $_accordionBlockNs,
                                    'id' => $_accordionBlockId++,
                                    'header' => 'Назначение',
                                    'open' => true
                                ])
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'checked' => true,
                                                'value' => 1
                                            ]
                                        ])
                                            Нематодозы
                                        @endcomponent
                                    </div>
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'value' => 2
                                            ]
                                        ])
                                            Трематодозы
                                        @endcomponent
                                    </div>
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'value' => 3
                                            ]
                                        ])
                                            Экстракт артишока
                                        @endcomponent
                                    </div>
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'value' => 4
                                            ]
                                        ])
                                            Цестодозы
                                        @endcomponent
                                    </div>
                                    <div class="_mb-sm _color-black">
                                        @component('site._widgets.checker.checker', [
                                            'attributes' => [
                                                'type' => 'checkbox',
                                                'name' => 'filter-1',
                                                'value' => 1
                                            ]
                                        ])
                                            Плахтянские корма
                                        @endcomponent
                                    </div>
                                @endcomponent
                                <hr class="separator _color-gray2 _mtb-def _hide-last">


                            @endcomponent
                        </div>
                    </div>
                </div>
                <div class="gcell gcell--def-9 gcell--lg-4-of-5">
                    <div class="box _def-ml-xxs">
                        @include('site._widgets.sort-controls.sort-controls', [
                            'form' => false
                        ])
                        <div>
                            <div class="_flex _flex-wrap _mt-md _nmb-sm">
                                <div class="filter-param">
                                    <div class="filter-param__value">КРС</div>
                                    <div class="filter-param__clear">&times;</div>
                                </div>
                                <div class="filter-param">
                                    <div class="filter-param__value">Хондроитин</div>
                                    <div class="filter-param__clear">&times;</div>
                                </div>
                                <div class="filter-param">
                                    <div class="filter-param__value">Эко-Био</div>
                                    <div class="filter-param__clear">&times;</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="_def-ml-xxs">
                        @include('site._widgets.item-list.item-list', [
                            'list' => [
                               config('mock.items')[0],
                               config('mock.items')[1],
                               config('mock.items')[2],
                               config('mock.items')[3],
                            ]
                        ])
                    </div>
                </div>
            </form>
            @include('site._widgets.pagination.pagination', ['show_all' => true])
            <hr class="separator _color-gray3 _mtb-xl">
        </div>
    </div>

    <div class="section _mb-xl _lg-mb-xxl">
        <div class="container">
            <div class="grid grid--auto _justify-between _items-center _mt-lg _def-mt-xxl _pb-def">
                <div class="gcell _mb-def _mr-def">
                    <div class="title title--size-h2">Просмотренные товары</div>
                </div>
                <div class="gcell _mb-def _self-end">
                    @include('site._widgets.elements.goto.goto', [
                        'href' => '#',
                        'to' => 'next',
                        'text' => 'смотреть все'
                    ])
                </div>
            </div>
            @include('site._widgets.item-list.item-slider')
        </div>
    </div>

    <div class="section _mb-xl _lg-mb-xxl">
        <div class="container">
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
@endsection
