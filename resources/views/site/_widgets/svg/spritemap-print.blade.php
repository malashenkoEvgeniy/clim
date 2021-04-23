@php
    $spritemap = @file_get_contents('./assets/svg/spritemap.svg');
    $symbols = [];
    if ($spritemap) {
        preg_match_all('/<symbol\s((?!<).)*>/', $spritemap, $_symbols);
        if ($_symbols) {
            foreach ($_symbols[0] as $_symbol) {
                 preg_match_all('/id="(((?!").)*)"/', $_symbol, $_ids);
                 if ($_ids) {
                    array_push($symbols, $_ids[1][0]);
                 }
            }
        }
    }
@endphp

@if (count($symbols))
    <div class="grid grid--3 grid--xs-4 grid--md-6 grid--def-10 grid--lg-12 _nml-xs _svg-spritemap">
    @foreach($symbols as $symbol)
        <div class="gcell _svg-spritemap__cell _pl-xs _mb-xs">
            <div class="_svg-spritemap__item" title="{{ $symbol }}">
                <div class="_svg-spritemap__head">
                    <div class="ratio ratio--1x1">
                        {!! SiteHelpers\SvgSpritemap::get($symbol, [
                            'class' => '_svg-spritemap__icon'
                        ]) !!}
                    </div>
                </div>
                <div class="_text-center">
                    <code id="__icon-{{ $symbol }}"
                            class="_svg-spritemap__name _ellipsis">
                        {{ $symbol }}
                    </code>
                    <code data-clipboard-target="#__icon-{{ $symbol }}"
                            class="_svg-spritemap__copy js-spritemap-clipboard">
                        copy
                    </code>
                </div>
            </div>
        </div>
    @endforeach
    </div>
    @push('head-styles')
        <style>
            ._svg-spritemap {
                margin: 1.6rem 0;
            }

            ._svg-spritemap__cell:hover {
                position: relative;
                z-index: 5;
            }

            ._svg-spritemap__item {
                padding: .75rem;
                min-height: 100%;
                fill: currentColor;
            }

            ._svg-spritemap__item:hover {
                background-color: #ffffff;
                box-shadow: 0 2px 4px rgba(0, 0, 0, .2);
                fill: #000;
            }

            ._svg-spritemap__head {
                border: 1px dashed rgba(0, 0, 0, .15);
                margin-bottom: .75rem;
            }

            ._svg-spritemap__name {
                font-style: italic;
            }

            ._svg-spritemap__copy {
                color: #7474f9;
                cursor: pointer;
            }

            ._svg-spritemap__copy::after {
                content: '\21b5';
            }

            ._svg-spritemap__copy:hover {
                text-decoration: underline;
                color: #9c9cf5;
            }
        </style>
    @endpush
@endif

