@php
    $currentRouteName = Route::currentRouteName();
    $is_profile_edit = preg_match('/site.profile-edit/', $currentRouteName);
    $is_email_change = preg_match('/site.profile-email-change/', $currentRouteName);
    $is_phone_change = preg_match('/site.profile-phone-change/', $currentRouteName);
    $is_password_change = preg_match('/site.profile-password-change/', $currentRouteName);
@endphp

<div class="side-links">
    <div>
        <a class="side-link {{ $is_profile_edit ? 'is-active' : null }}"
            {!! $is_profile_edit ? null : sprintf("href=\"%s\"", route('site.profile-edit')) !!}
        >Редактировать личные данные</a>
    </div>
    {{--<div>
        <a class="side-link {{ $is_email_change ? 'is-active' : null }}"
            {!! $is_email_change ? null : sprintf("href=\"%s\"", route('site.profile-email-change')) !!}
        >Изменить эл. почту</a>
    </div>--}}
    <div>
        <a class="side-link {{ $is_phone_change ? 'is-active' : null }}"
            {!! $is_phone_change ? null : sprintf("href=\"%s\"", route('site.profile-phone-change')) !!}
        >Изменить телефон</a>
    </div>
    <div>
        <a class="side-link {{ $is_password_change ? 'is-active' : null }}"
            {!! $is_password_change ? null : sprintf("href=\"%s\"", route('site.profile-password-change')) !!}
        >Изменить пароль</a>
    </div>
</div>
