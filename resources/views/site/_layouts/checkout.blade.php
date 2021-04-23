@extends('site._layouts._base')

@section('body')
    <div id="layout" class="layout layout--checkout">
        <div class="layout__body">
            @include('site._widgets.header.header--checkout')
            @yield('layout-body')
        </div>

        <div class="layout__footer">
            @include('site._widgets.footer.footer--checkout')
        </div>
    </div>

    @include('site._widgets.scripts.scripts')
    @include('site._widgets.scripts.noscript')
    @include('site._widgets.hidden-data.index')
@endsection
