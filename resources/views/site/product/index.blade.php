@extends('site._layouts.main')

{{-- TODO Убрать и передавать значения с контроллера --}}
@push('viewTitle', config('mock.nav-links.product')->text_content)
{{-- ENDTODO Убрать и передавать значения с контроллера --}}

@section('layout-breadcrumbs')
    <div class="section">
        <div class="container">
            @include('site._widgets.breadcrumbs.breadcrumbs', ['list' => [
                config('mock.nav-links.index'),
                config('mock.nav-links.catalog-group'),
                config('mock.nav-links.catalog-1')
            ]])
        </div>
    </div>
@endsection

@section('layout-body')
    <div class="section">
        <div class="container">
            <div class="box box--gap">
                <div class="grid _items-center _sm-flex-nowrap">
                    <div class="gcell gcell--12 gcell--sm-auto _flex-grow _mb-sm _sm-mb-none">
                        <div class="title title--size-h1">
                            {{ config('mock.nav-links.product')->text_content }}
                        </div>
                    </div>
                    <div class="gcell _sm-pl-md _flex-noshrink">
                        @include('site._widgets.elements.vendor-code.vendor-code', [
                            'code' => 've-20122'
                        ])
                    </div>
                </div>
            </div>
            @include('site._widgets.product.product', [
                'ns' => 'product',
                'product' => (object)[
                    'badges' => [
                        (object)[
                            'type' => 'top',
                            'text' => 'top'
                        ],
                        (object)[
                            'type' => 'new',
                            'text' => 'top'
                        ]
                    ]
                ],
                'nav' => [
                    (object)[
                        'name' => 'Все о товаре',
                        'template' => 'site._widgets.product.product-facade.product-facade'
                    ],
                    (object)[
                        'name' => 'Описание',
                        'template' => 'site._widgets.product.product-desc.product-desc'
                    ],
                    (object)[
                        'name' => 'Характеристики',
                        'template' => 'site._widgets.product.product-specifications.product-specifications'
                    ],
                    (object)[
                        'name' => 'Инструкции',
                        'template' => 'site._widgets.product.product-instructions.product-instructions'
                    ],
                    (object)[
                        'name' => 'Регистрационное свидетельство',
                        'template' => 'site._widgets.product.product-certificate.product-certificate'
                    ]
                ]
            ])
        </div>
    </div>
    <div class="section _mb-lg">
        <div class="container">
            <div class="grid grid--auto _justify-between _items-center _mt-lg _def-mt-xxl _pb-def">
                <div class="gcell _mb-def _mr-def">
                    <div class="title title--size-h2">Сопутствующие товары</div>
                </div>
                <div class="gcell _mb-def _self-end _md-show">
                    @include('site._widgets.elements.arrows.items')
                </div>
            </div>
            @include('site._widgets.item-list.item-slider', array('preset'=>'SlickItemWithArrow', 'add_dot_classes' => '_md-hide'))
        </div>
    </div>
    <div class="section _mb-lg">
        <div class="container">
            <div class="grid grid--auto _justify-between _items-center _mt-lg _def-mt-xxl _pb-def">
                <div class="gcell _mb-def _mr-def">
                    <div class="title title--size-h2">Аналоги</div>
                </div>
                <div class="gcell _mb-def _self-end _md-show">
                    @include('site._widgets.elements.arrows.items')
                </div>
            </div>
            @include('site._widgets.item-list.item-slider', array('preset'=>'SlickItemWithArrow', 'add_dot_classes' => '_md-hide'))
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
@endsection
