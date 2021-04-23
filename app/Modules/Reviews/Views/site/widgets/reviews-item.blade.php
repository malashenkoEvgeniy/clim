<div class="reviews-item {{ $mod_class ?? '' }}">
    <div class="reviews-item-user">
        <div class="reviews-item-user__about">
            <div class="reviews-item-user__name" title="{{ $user_name }}">
                <div class="_ellipsis">{{ $user_name }}</div>
            </div>
        </div>
    </div>
    <div class="reviews-item-message {{ $mod_message_class ?? '' }}">
        {{ $slot }}
    </div>
</div>
