<div class="item-card-controls">
    <div class="item-card-controls__control _def-flex-grow">
        <button class="button button--theme-item-buy button--size-collapse-normal button--width-full">
            <span class="button__body">
                {!! SiteHelpers\SvgSpritemap::get('icon-shopping', [
                    'class' => 'button__icon button__icon--before'
                ]) !!}
                <span class="button__text">Купить</span>
            </span>
        </button>
    </div>
    <div class="item-card-controls__control _flex-noshrink">
        <button class="button button--theme-item-action button--size-normal is-active" onclick="this.classList.toggle('is-active')">
            <span class="button__body">
                {!! SiteHelpers\SvgSpritemap::get('icon-to-compare', [
                    'class' => 'button__icon button__icon--before'
                ]) !!}
            </span>
        </button>
    </div>
    <div class="item-card-controls__control _flex-noshrink">
        <button class="button button--theme-item-action button--size-normal" onclick="this.classList.toggle('is-active')">
            <span class="button__body">
                {!! SiteHelpers\SvgSpritemap::get('icon-to-wishlist', [
                    'class' => 'button__icon button__icon--before'
                ]) !!}
            </span>
        </button>
    </div>
</div>
