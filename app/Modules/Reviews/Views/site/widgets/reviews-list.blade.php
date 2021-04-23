@php
/** @var \App\Modules\Reviews\Models\Review[] $reviews */
@endphp
<div class="grid _nm-md _def-nm-def">
    @foreach($reviews as $review)
        <div class="gcell gcell--12 gcell--ms-6 gcell--lg-4 _p-md _def-p-def">
            @component('reviews::site.widgets.reviews-item', [
                'mod_class' => 'reviews-item--theme-dark',
                'mod_message_class' => 'reviews-item-message--def',
                'user_name' => $review->name,
            ])
                {!! $review->comment !!}
            @endcomponent
        </div>
    @endforeach
</div>
