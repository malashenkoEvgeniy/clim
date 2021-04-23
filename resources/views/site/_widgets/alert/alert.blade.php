<div class="alert alert--{{ $alert_type }}">
    <div class="grid _flex-nowrap">
        @if(isset($alert_icon))
            <div class="gcell gcell--auto _flex-noshrink _pr-def">
                <div class="alert__icon">
                    {!! SiteHelpers\SvgSpritemap::get($alert_icon, []) !!}
                </div>
            </div>
        @endif
        <div class="gcell gcell--auto _flex-grow">
            <div class="grid _justify-between _nm-sm">
                @if(!empty(strip_tags($slot)))
                    <div class="gcell gcell--auto _flex-grow _p-sm">
                        <div class="alert__content">
                            {{ $slot }}
                        </div>
                    </div>
                @endif
                @if(!empty($alert_button))
                    <div class="gcell gcell--auto _flex-noshrink _p-sm">
                        {{ $alert_button }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
