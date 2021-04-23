@php
/** @var \App\Modules\Products\Models\Product $product */
/** @var string $comments */
@endphp
@if($comments)
    <div class="grid _def-flex-nowrap _items-center _justify-between _nm-md _pb-md">
        <div class="gcell _p-md">
            <div class="title title--size-h3"><span class="_color-gray5">Отзывы о</span> {{ $product->name }}
            </div>
        </div>
        <div class="gcell _p-md _flex-noshrink">
            <button class="button button--size-normal button--theme-main js-init"
                    data-scroll-window='{"target":"#review-form","offsetY":"100","focus":"#review-message"}'>
                <span class="button__body">
                    {!! SiteHelpers\SvgSpritemap::get('icon-review', [
                        'class' => 'button__icon button__icon--before'
                    ]) !!}
                    <span class="button__text">Написать отзыв</span>
                </span>
            </button>
        </div>
    </div>
    <div class="review-container">
        {!! $comments !!}
    </div>
@endif

{!! Widget::show('comments::product-review-form', 'groups', $product->group_id) !!}
