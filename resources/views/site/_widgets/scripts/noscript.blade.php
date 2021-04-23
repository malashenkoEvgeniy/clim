<noscript>
    <link rel="stylesheet" href="{{ site_media('assets/css/bundle-noscript.css', true) }}">
    <div class="noscript-msg">
        <input id="noscript-msg__input" class="noscript-msg__input" type="checkbox">
        <div class="noscript-msg__container">
            <label class="noscript-msg__close" for="noscript-msg__input"
                    title="{{ __('noscript-msg.close_notification') }}">&times;</label>
            <div class="noscript-msg__content">
                <p>
                    <b>{{ __('noscript-msg.disabled_javascript') }}</b><br>
                    {{ __('noscript-msg.required_javascript') }}
                </p>
                <p>{{ __('noscript-msg.enable_javascript') }}</p>
            </div>
        </div>
    </div>
</noscript>
