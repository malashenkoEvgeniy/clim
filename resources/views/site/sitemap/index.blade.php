@extends('site._layouts.main')

{{-- TODO Убрать и передавать значения с контроллера --}}
@push('viewTitle', 'Карта сайта')
{{-- ENDTODO Убрать и передавать значения с контроллера --}}

@section('layout-breadcrumbs')
    <div class="section">
        <div class="container">
            @include('site._widgets.breadcrumbs.breadcrumbs', ['list' => [
                config('mock.nav-links.index'),
                config('mock.nav-links.catalog-group')
            ]])
        </div>
    </div>
@endsection

@section('layout-body')
    <div class="section _mb-lg">
        <div class="container">
            <div class="box">
                <div class="title title--size-h1">Карта сайта</div>
            </div>
        </div>
@push('head-styles')
<link rel="stylesheet" href="{{ site_media('assets/css/bundle-sitemap.css', true) }}">
@endpush
        <div class="container _mb-xl _def-mb-xxl">
            <div class="box">
                <nav class="sitemap">
                    <ul>
                        <li>
                            <a href="#"><span>Test</span></a>
                        </li>
                        <li>
                            <a href="#"><span>Test</span></a>
                        </li>
                        <li>
                            <a href="#"><span>Test</span></a>
                            <ul>
                                <li>
                                    <a href="#"><span>Test</span></a>
                                </li>
                                <li>
                                    <a href="#"><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto enim error maxime!</span></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><span>Test</span></a>
                            <ul>
                                <li>
                                    <a href="#"><span>Test</span></a>
                                </li>
                                <li>
                                    <a href="#"><span>Test</span></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><span>Test</span></a>
                            <ul>
                                <li>
                                    <a href="#"><span>Test</span></a>
                                </li>
                                <li>
                                    <a href="#"><span>Test</span></a>
                                    <ul>
                                        <li>
                                            <a href="#"><span>Test</span></a>
                                        </li>
                                        <li>
                                            <a href="#"><span>Test</span></a>
                                            <ul>
                                                <li>
                                                    <a href="#"><span>Test</span></a>
                                                </li>
                                                <li>
                                                    <a href="#"><span>Test</span></a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#"><span>Test</span></a>
                                </li>
                                <li>
                                    <a href="#"><span>Test</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
