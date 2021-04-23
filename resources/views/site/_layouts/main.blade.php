@extends('site._layouts._base')

@section('body')
    <div id="layout" class="layout layout--site">
        <div class="layout__body">
            @include('site._widgets.header.header')
            {!! Widget::show('breadcrumbs') !!}
            @if(!isset($hideH1) || $hideH1 === false)
                {!! Widget::show('h1', $centerH1 ?? false) !!}
            @endif
            @yield('layout-body')
        </div>

        <!--main_page_h1_placeholder-->
        <div class="layout__footer">
            {!! Widget::show('subscribe::form') !!}
            {!! Widget::show('seo-block') !!}
            @include('site._widgets.footer.footer')
        </div>

        @include('site._widgets.fixed-menu.fixed-menu')
    </div>

    @include('site._widgets.scripts.scripts')
    @include('site._widgets.scripts.noscript')
    @include('site._widgets.hidden-data.index')
@endsection
