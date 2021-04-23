@php($socials = Widget::show('social-networks'))
<div id="popup-regauth" class="popup popup--regauth {{ $socials ? '' : '_pb-xl' }}">
    <div class="wstabs-block is-active" data-wstabs-ns="regauth" data-wstabs-block="1">
        @include('users::site.popups.login')
    </div>
    <div class="wstabs-block" data-wstabs-ns="regauth" data-wstabs-block="2">
        @include('users::site.popups.registration')
    </div>
    <div class="wstabs-block" data-wstabs-ns="regauth" data-wstabs-block="3">
        @include('users::site.popups.forgot-password')
    </div>
    @if($socials)
        <div class="popup__social-section">
            <div class="popup__container _mt-xl">
                <div class="popup__desc _text-center _mb-def">@lang('users::site.login-by-social-networks')</div>
                <div class="grid _justify-center _nmlr-sm">
                    {!! $socials !!}
                </div>
            </div>
        </div>
    @endif
</div>
