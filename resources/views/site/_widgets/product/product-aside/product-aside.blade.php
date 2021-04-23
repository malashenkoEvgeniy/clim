<div class="product-aside _separator-left _p-def _def-show">
    <div class="product-aside__sticky">
        <div class="grid _flex-nowrap _items-center _separator-bottom _pb-def _mb-def">
            <div class="gcell _flex-noshrink _pr-md">
                <img class="item-offer__image" width="60" height="60" alt="{{ config('mock.product')->info->name }}" {!! Html::attributes([
                    'src' => site_media('/temp/product/thumbs/001.jpg')
                ]) !!}>
            </div>
            <div class="gcell">
                <span class="_color-black">{{ config('mock.product')->info->name }}</span>
            </div>
        </div>
        <div class="product-price">
            <div class="product-price__old">124.55 грн</div>
            <div class="product-price__current">87.60 грн</div>
        </div>
        <div class="product-status _separator-bottom _pb-def _mb-def">
            <div class="product-status__icon">
                {!! SiteHelpers\SvgSpritemap::get(config('mock.product')->info->status ? 'icon-available' : 'icon-not-available') !!}
            </div>
            <div class="product-status__text">{{ config('mock.product')->info->status ? 'В наличии' : 'Нет в наличии' }}</div>
        </div>
        <div class="grid _justify-between _separator-bottom _pb-def _mb-def">
            <div class="gcell gcell--7 _pr-lg">
                <button class="button button--theme-main button--size-normal button--width-full">
                    <span class="button__body">
                        {!! SiteHelpers\SvgSpritemap::get('icon-shopping', [
                            'class' => 'button__icon button__icon--before'
                        ]) !!}
                        <span class="button__text">Купить</span>
                    </span>
                </button>
            </div>
            <div class="gcell gcell--5 _separator-left">
                <div class="grid _justify-end _nml-sm">
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
    </div>
</div>
