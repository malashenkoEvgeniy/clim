<div class="grid _items-center _flex-nowrap _pl-sm _xl-pl-def _def-show">
    @if($main)
        <div class="gcell _pl-sm _xl-pl-def">
            @include('site-custom.static.phone-number.phone-number', [
                'phone' => $main,
                'link_mod_classes' => 'phone-number__link--size-xl',
                'show_description' => true
            ])
        </div>
    @endif
    @if($additions && count($additions) > 0)
        <div class="gcell _pl-sm _xl-pl-def">
            @foreach($additions as $phone)
                @if ($phone->text_content != null)
                    @include('site-custom.static.phone-number.phone-number', [
                        'phone' => $phone,
                    ])
                @endif
            @endforeach
        </div>
    @endif

    @if ($schedule)
        <div class="gcell _pl-sm _xl-pl-def _xl-show">
            @include('site-custom.static.schedule-work.schedule-work')
        </div>
    @endif
        <div class="gcell _pl-sm _xl-pl-def">
            {!! Widget::show('callback-button') !!}
        </div>
</div>
