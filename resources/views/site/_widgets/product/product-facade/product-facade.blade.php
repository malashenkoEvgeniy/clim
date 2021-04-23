<div class="grid _nmlr-def">
    <div class="gcell gcell--12 gcell--sm-7 gcell--def-6 _plr-def">
        <div class="_posr">
            @if($product->badges)
                <div class="product-badges">
                    @foreach($product->badges as $badge)
                        @include('site._widgets.item-badge.item-badge', [
                            'type' => $badge->type,
                            'text' => $badge->text
                        ])
                    @endforeach
                </div>
            @endif
            @include('site._widgets.product.product-facade.product-facade-slider', [
                'images' => [
                    '001.jpg',
                    '002.jpg',
                    '001.jpg',
                    '002.jpg',
                    '001.jpg',
                    '002.jpg',
                    '001.jpg',
                    '002.jpg',
                    '001.jpg',
                    '002.jpg',
                    '001.jpg',
                    '002.jpg',
                ]
            ])
        </div>
    </div>
    <div class="gcell gcell--5 gcell--def-3 _plr-def _separator-left">
        <div class="product-price">
            <div class="product-price__old">124.55 грн</div>
            <div class="product-price__current">87.60 грн</div>
        </div>
        @php($status = true)
        <div class="product-status _separator-bottom _pt-sm _pb-def _mb-def">
            <div class="product-status__icon">
                {!! SiteHelpers\SvgSpritemap::get($status ? 'icon-available' : 'icon-not-available') !!}
            </div>
            <div class="product-status__text">{{ $status ? 'В наличии' : 'Нет в наличии' }}</div>
        </div>
        <div class="grid _flex-nowrap _justify-between _separator-bottom _pb-def _mb-def _nmlr-md">
            <div class="gcell gcell--lg-6 _plr-md">
                <button class="button button--theme-main button--size-normal button--width-full">
                    <span class="button__body">
                        {!! SiteHelpers\SvgSpritemap::get('icon-shopping', [
                            'class' => 'button__icon button__icon--before'
                        ]) !!}
                        <span class="button__text">Купить</span>
                    </span>
                </button>
            </div>
            <div class="gcell gcell--lg-5 _separator-left _plr-md">
                <div class="grid _flex-nowrap _justify-end _nml-sm">
                    <div class="gcell _pl-sm">
                        <button class="button button--theme-item-action button--size-normal is-active" onclick="this.classList.toggle('is-active')">
                            <span class="button__body">
                                {!! SiteHelpers\SvgSpritemap::get('icon-to-compare', [
                                    'class' => 'button__icon button__icon--before'
                                ]) !!}
                            </span>
                        </button>
                    </div>
                    <div class="gcell _pl-sm">
                        <button class="button button--theme-item-action button--size-normal" onclick="this.classList.toggle('is-active')">
                            <span class="button__body">
                                {!! SiteHelpers\SvgSpritemap::get('icon-to-wishlist', [
                                    'class' => 'button__icon button__icon--before'
                                ]) !!}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid _justify-center _separator-bottom _pb-def _mb-def">
            <div class="gcell">
                <a href="#" class="link link--dashed js-init" data-mfp="inline" data-mfp-src="#popup-one-click-buy">Купить в один клик</a>
            </div>
        </div>
        <div class="title title--size-h4 _color-gray4">ОСНОВНЫЕ ХАРАКТЕРИСТИКИ:</div>
        <div class="grid _nmtb-sm">
            @foreach(config('mock.product')->main_spec as $spec)
            <div class="gcell gcell--12 _ptb-xs _lg-ptb-sm">
                <strong class="text text--size-13 _color-black">{{ $spec->key }}:</strong>
                <span class="text text--size-13 _color-gray3">{{ $spec->val }}</span>
            </div>
            @endforeach
        </div>
    </div>
    <div class="gcell gcell--12 gcell--def-3 _def-plr-def _pt-def _def-pt-none _separator-left">
        <div class="grid">
            @if(config('mock.product')->offers)
                <div class="gcell gcell--7 gcell--def-12 _def-flex-order-1">
                    <div class="title title--size-h4 _color-gray4">ДОСТУПНЫЕ ПРЕДЛОЖЕНИЯ:</div>
                    <div class="product-offers">
                        <div class="product-offers__list js-init" data-perfect-scrollbar>
                            @foreach(config('mock.product')->offers as $offer)
                                <div class="product-offers__item">
                                    @include('site._widgets.item-offer.item-offer', [
                                        'slug' => $offer->slug,
                                        'image' => $offer->image,
                                        'name' => $offer->name
                                    ])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <div class="gcell gcell--5 gcell--def-12 _def-mb-def">
                <div class="grid">
                    <div class="gcell gcell--12 _mb-def">
                        @include('site._widgets.conditions-item.conditions-item', [
                            'icon' => 'icon-delivery',
                            'title' => 'Условия доставки',
                            'slug' => 'ui'
                        ])
                    </div>
                    <div class="gcell gcell--12">
                        @include('site._widgets.conditions-item.conditions-item', [
                            'icon' => 'icon-payment',
                            'title' => 'Варианты оплаты',
                            'slug' => 'ui'
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
