@php
$show_menu = true;
@endphp

@extends('site._layouts.main')

@section('layout-body')
    <div class="section _mb-def">
        <div class="container">
            <div class="box box--gap">
                <div class="grid _items-center _sm-flex-nowrap">
                    <div class="gcell _flex-grow">
                        <h1 class="title title--size-h1">О компании</h1>
                    </div>
                </div>
            </div>
            <div class="grid _flex-nowrap _items-start">
                <div class="gcell gcell--3 _flex-noshrink _def-show _def-pr-def">
                    <div class="sidebar">
                        <div class="sidebar__body">
                            @foreach(config('mock.text-links')->about as $item)
                                @include('site._widgets.sidebar.sidebar-item', [
									'data' => $item,
								])
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="gcell _flex-grow">
                    <div class="box">
                        <article class="wysiwyg">
                            <div class="scroll-text">
                                <div class="scroll-text__content wysiwyg js-init"
                                    data-wrap-media
                                    data-prismjs
                                    data-draggable-table
                                    data-perfect-scrollbar
                                >
                                    <h2>Корпорация «Locotradeпромпостач»</h2>
                                    <p>Разработчик и производитель профессиональных препаратов для ветеринарии, крупнейший производитель премиксов, БМВД и комбикормов. Уже почти четверть века корпорация
                                        «Locotradeпромпостач» обеспечивает доступность инновационной ветеринарной продукции для владельцев всех видов животных.</p>
                                    <img src="{{ site_media('/temp/about.jpg') }}" alt="">
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section section--about-info">
        <div class="container _mtb-lg _def-mtb-xxl">
            @include('site._widgets.about.mission')
        </div>
        <div class="container _mtb-lg _def-mtb-xxl">
            @include('site._widgets.about.locations')
        </div>
        <div class="container _mtb-lg _def-mtb-xxl">
            @include('site._widgets.about.laboratory')
        </div>
    </div>

    <div class="section section--about-qa _mb-lg">
        <div class="container">
            @include('site._widgets.about.qa')
        </div>
    </div>

    <div class="section_mb-lg">
        <div class="container">
            @include('site._widgets.about.partners')
        </div>
    </div>

    <div class="section _mb-lg">
        <div class="container">
            <div class="_mt-lg _def-mt-xxl _pb-xl">
                <div class="title title--size-h2">Основные принципы ведения бизнеса </div>
            </div>
            @include('site._widgets.feature-slider.feature-slider', [
                'list' => [
                    config('mock.features')[5],
                    config('mock.features')[6],
                    config('mock.features')[7],
                    config('mock.features')[8],
                    config('mock.features')[5]
                ],
                'slides_to_show' => 5,
                'split' => true
            ])
        </div>
    </div>
@endsection
