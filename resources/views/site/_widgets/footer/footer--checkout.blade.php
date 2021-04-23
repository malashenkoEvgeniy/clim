@if(config('db.basic.company'))
    <div class="section section--black _ptb-md _no-print">
        <div class="container">
            <div class="grid _justify-between _items-center">
                <div class="gcell">
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
                    <a href="//locotrade.com.ua" target="_blank" class="link link--invert text text--size-13">@lang('global.locotrade_text')</a>
                </div>
            </div>
        </div>
    </div>
@endif
{!! Widget::show('seo-metrics', 'counter') !!}
