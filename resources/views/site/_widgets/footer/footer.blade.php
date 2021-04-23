@php
    $logo_image = false; /*TODO если изображение логотипа загруженоб иначе выводится текстовое поле (по умолчанию имя домена)*/
@endphp

@if(browserizr()->isDesktop())
    <div class="section section--footer-top _def-show">
        <div class="container">
            <div class="grid grid--1 _nml-xl">
                <div class="gcell gcell--md-3 _pl-xl">
                    <div class="_mb-def">
                        {!! Widget::show('logo') !!}
                    </div>
                    <div class="_mb-def">
                        @include('site._widgets.elements.copyright.copyright')
                    </div>
                    <div class="_mb-def">
                        <div class="grid _nm-sm _items-center">
                            <div class="gcell _p-sm">
                                <img class="js-lozad" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='25'%3E%3C/svg%3E" data-src="{{ site_media('/static/images/payment-methods/liqpay.png') }}" width="90" height="19" alt="Liqpay">
                            </div>
                            <div class="gcell _p-sm">
                                <img class="js-lozad" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='112' height='36'%3E%3C/svg%3E" data-src="{{ site_media('/static/images/payment-methods/nova-poshta.png') }}" width="112" height="36" alt="Nova Poshta">
                            </div>
                        </div>
                        <div class="grid _nm-sm _items-center">
                            <div class="gcell _p-sm">
                                <img class="js-lozad" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='25'%3E%3C/svg%3E" data-src="{{ site_media('/static/images/payment-methods/visa.png') }}" width="51" height="17" alt="Visa">
                            </div>
                            <div class="gcell _p-sm">
                                <img class="js-lozad" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='112' height='36'%3E%3C/svg%3E" data-src="{{ site_media('/static/images/payment-methods/mastercard.png') }}" width="41" height="32" alt="MasterCard">
                            </div>
                        </div>
                    </div>
                    @if(Route::has('site.sitemap'))
                        <div class="_mb-def">
                            <a href="{{ route('site.sitemap') }}" class="link link--black text text--size-13">@lang('global.sitemap')</a>
                        </div>
                    @endif
                </div>
                <div class="gcell gcell--md-9 _pl-xl">
                    <div class="grid grid--1 grid--def-4 _nml-def _lg-nml-lg">
                        {!! Widget::show('categories::footer-menu') !!}
                        {!! Widget::show('footer-menu') !!}
                        {!! Widget::show('contacts', 'footer') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@if(config('db.basic.company'))
    <div class="section section--black">
        <div class="container">
            <div class="grid _justify-between _items-center">
                <div class="gcell _def-pl-none _pl-xl">
                    <div class="text text--size-13 _color-gray6">
                        <p>
                            @if(config('db.basic.company'))
                                &copy; {{ config('db.basic.company') }}
                            @else
                                &nbsp;
                            @endif
                        </p>
                    </div>
                </div>
                <div class="gcell">
                    <a href="https://www.darwinglobal.com.ua/" target="_blank" rel="nofollow" class="link link--invert text text--size-13">Продвижение сайтов</a>
                </div>
            </div>
        </div>
    </div>
@endif
{!! Widget::show('seo-metrics', 'counter') !!}
