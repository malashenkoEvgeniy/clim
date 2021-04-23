@php
    $user_avatar_src = 'static/images/placeholders/no-avatar-76x76.png';
    if (isset($user_avatar)) {
        $user_avatar_src = 'temp/' . $user_avatar;
    }
@endphp
<div class="reviews-item {{ $mod_class ?? '' }}">
    <div class="reviews-item-user">
        <div class="reviews-item-user__avatar">
            <img src="{{ site_media($user_avatar_src) }}" alt width="76" height="76" class="">
        </div>
        <div class="reviews-item-user__about">
            <div class="reviews-item-user__name" title="{{ $user_name }}">
                <div class="_ellipsis">{{ $user_name }}</div>
            </div>
            <div class="reviews-item-user__desc" title="{{ $user_about }}">
                <div class="_ellipsis">{{ $user_about }}</div>
            </div>
        </div>
    </div>
    <div class="reviews-item-message {{ $mod_message_class ?? '' }}">
        {{ $slot }}
    </div>
</div>
