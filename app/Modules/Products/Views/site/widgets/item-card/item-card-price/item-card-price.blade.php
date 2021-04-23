<div class="item-card-price">
    @if($old_value)
        <del class="item-card-price__old-value _ellipsis" title="{{ $old_value }}">
            {{ $old_value }}
        </del>
    @endif
    <div class="item-card-price__value _ellipsis" title="{{ $value }}">
        {{ $value }}
    </div>
</div>
