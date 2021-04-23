
<div class="section section--fixed _def-show-mobile _bgcolor-black">
    <div class="section__fixed">
        <div class="container">
            @include('site._widgets.header.header-mobile.header-mobile')
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        @include('site._widgets.header.header-info.header-info')
    </div>
</div>

@if(browserizr()->isDesktop())
    <div class="section section--sticky-over _bgcolor-gray8 _def-show">
        <div class="container">
            {!! Widget::show('header-menu') !!}
        </div>
    </div>
@endif
@include('site._widgets.action-bar.action-bar')

{{--================Old vresion=================--}}
{{--@if(browserizr()->isDesktop())--}}
{{--    <div class="section section--sticky-over _bgcolor-gray8 _def-show">--}}
{{--        <div class="container">--}}
{{--            {!! Widget::show('header-menu') !!}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endif--}}
{{--<div class="section section--fixed _def-show-mobile _bgcolor-black">--}}
{{--    <div class="section__fixed">--}}
{{--        <div class="container">--}}
{{--            @include('site._widgets.header.header-mobile.header-mobile')--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<div class="section">--}}
{{--    <div class="container">--}}
{{--        @include('site._widgets.header.header-info.header-info')--}}
{{--    </div>--}}
{{--</div>--}}
{{--@include('site._widgets.action-bar.action-bar')--}}
