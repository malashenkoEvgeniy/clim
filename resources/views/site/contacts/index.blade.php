@extends('site._layouts.main')

{{-- TODO Убрать и передавать значения с контроллера --}}
@push('viewTitle', config('mock.nav-links.contacts')->text_content)
{{-- ENDTODO Убрать и передавать значения с контроллера --}}

@section('layout-breadcrumbs')
    <div class="section">
        <div class="container">
            @include('site._widgets.breadcrumbs.breadcrumbs', ['list' => [
                config('mock.nav-links.index'),
                config('mock.nav-links.contacts')
            ]])
        </div>
    </div>
@endsection

@section('layout-body')
    <div class="section">
        <div class="container">
            <div class="box box--gap">
                <div class="title title--size-h1">
                    {{ config('mock.nav-links.contacts')->text_content }}
                </div>
            </div>
        </div>
    </div>
    <div class="section _mb-lg">
        <div class="container">
            <div class="grid grid--1 grid--md-2 _nml-xxs">
                <div class="gcell _pl-xxs">
                    <div class="box box--full-height _color-black">
                        Горячая линия
                    </div>
                </div>
                <div class="gcell _pl-xxs">
                    <div class="box box--full-height _color-black">
                        Отдел продаж
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section _mb-lg">
        <div class="container">
            <div class="title title--size-h1 _mt-xl _mb-lg">
                Наши филиалы
            </div>
            <div>
                <div class="grid grid--1">
                    <div class="gcell gcell--ms-5 gcell--def-4 gcell--lg-3">
                        <div class="tabs-nav _md-flex">
                            <div class="tabs-nav__button is-active"
                                data-wstabs-ns="contacts-map"
                                data-wstabs-button="1">
                                <span>Украина</span>
                            </div>
                            <div class="tabs-nav__button"
                                data-wstabs-ns="contacts-map"
                                data-wstabs-button="2">
                                <span>Киевская область</span>
                            </div>
                        </div>
                    </div>
                    <div class="gcell gcell--ms-7 gcell--def-8 gcell--lg-9"></div>
                    <div class="gcell gcell--ms-5 gcell--def-4 gcell--lg-3">
                        <div class="box box--full-height _color-black">
                            <div class="tabs-blocks">
                                <div class="tabs-blocks__block _p-none is-active"
                                        data-wstabs-ns="contacts-map"
                                        data-wstabs-block="1">
                                    <select class="select">
                                        <option value="1">Option b1</option>
                                        <option value="2">Option b2</option>
                                        <option value="3">Option b3</option>
                                        <option value="4">Option b4</option>
                                        <option value="5">Option b5</option>
                                    </select>
                                </div>
                                <div class="tabs-blocks__block _p-none"
                                        data-wstabs-ns="contacts-map"
                                        data-wstabs-block="2">
                                    Таб 2
                                    <select class="select">
                                        <option value="1">Option a1</option>
                                        <option value="2">Option a2</option>
                                        <option value="3">Option a3</option>
                                        <option value="4">Option a4</option>
                                        <option value="5">Option a5</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gcell gcell--ms-7 gcell--def-8 gcell--lg-9 _posr">
                        <div class="map-holder map-holder--contacts">
                            {{-- один контейнер для карты --}}
                            {{-- данные для подключения в LOCO_DATA --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section _mb-lg">
        <div class="container">
            <div class="title title--size-h1 _mt-xl _mb-lg">
                Ждем Вас в центральном офисе
            </div>
            <div class="box _color-black">
                Ждем Вас в центральном офисе
            </div>
        </div>
    </div>
@endsection
