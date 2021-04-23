@php
/** @var \App\Modules\Reviews\Models\Review[] $reviews */
/** @var string $image */
@endphp
<div class="section section--reviews _mt-lg _def-mt-xxl _pb-xxl _ovh _color-white js-lozad" data-background-image="{{ $image }}">
    <div class="container container--def">
        <div class="_mt-lg _def-mt-xxl _pb-xl _text-center">
            <div class="title title--size-h2 title--theme-white">
                @choice('reviews::site.widget-title', $reviews->count())
            </div>
        </div>
        @include('reviews::site.widgets.reviews-slider', [
            'mod_class' => 'reviews-slider--theme-light',
            'reviews' => $reviews,
        ])
    </div>
</div>
