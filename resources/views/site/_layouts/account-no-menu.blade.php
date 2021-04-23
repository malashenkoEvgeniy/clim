@extends('site._layouts._base')

@section('body')
    <div id="layout" class="layout layout--account">
        <div class="layout__body">
            @include('site._widgets.header.header')
            {!! Widget::show('breadcrumbs') !!}
            @if(!isset($hideH1) || $hideH1 === false)
                {!! Widget::show('h1', $centerH1 ?? false) !!}
            @endif
            <div class="section _mt-lg">
                <div class="container">
                    <div class="grid">
                        @yield('account-content')
                    </div>
                </div>
            </div>
        </div>

        <div class="layout__footer">
            {!! Widget::show('seo-block') !!}
            @include('site._widgets.footer.footer')
        </div>

        @include('site._widgets.fixed-menu.fixed-menu')
    </div>

    @include('site._widgets.scripts.scripts')
    @include('site._widgets.scripts.noscript')
    @include('site._widgets.hidden-data.index')
@endsection
