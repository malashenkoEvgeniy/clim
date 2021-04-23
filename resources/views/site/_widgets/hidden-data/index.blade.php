<div hidden>
    @include('site._widgets.hidden-data.mobile-menu')
    @include('site._widgets.hidden-data.popups')
    @stack('hidden_data')
</div>

@if(!config('allow-cookie-usage'))
    @include('site._widgets.hidden-data.cookie-info.cookie-info')
@endif
