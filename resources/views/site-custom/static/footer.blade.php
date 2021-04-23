<div class="gcell _pl-def _lg-pl-lg">
    @if($main || ($additions && count($additions) > 0) || $mail)
        <div class="title title--size-h4">@lang('site.hot-line-text')</div>
    @endif
    <div class="_mtb-def">
        @if($main)
            <div class="_mb-xs">
                @include('site-custom.static.phone-number.phone-number', [
                    'phone' => $main,
                    'link_mod_classes' => 'phone-number__link--size-lg',
                    'show_description' => true,
                ])
            </div>
        @endif
        @if($additions && count($additions) > 0)
            <div class="_mb-xs">
                @foreach($additions as $phone)
                    @include('site-custom.static.phone-number.phone-number', [
                        'phone' => $phone,
                    ])
                @endforeach
            </div>
        @endif
        @if($mail)
            <div class="_mb-xs">
                @include('site-custom.static.schedule-work.schedule-work')
            </div>
            <div class="_mb-xs">
                @include('site-custom.static.mail-link.mail-link', [
                    'link' => $mail,
                ])
            </div>
        @endif
    </div>
</div>
