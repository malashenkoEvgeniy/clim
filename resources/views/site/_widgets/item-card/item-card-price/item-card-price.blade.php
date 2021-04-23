<div class="item-card-price">
    @if(isset($old_value))
        <del class="item-card-price__old-value _ellipsis" title="{{ $old_value }} грн">
            {{ $old_value }} грн
        </del>
    @endif
    <div class="item-card-price__value _ellipsis" title="{{ $value }} грн">
        {{ $value }} грн
    </div>
</div>
