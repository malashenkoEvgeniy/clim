<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', Seo::meta()->getTitle(config('app.name')))</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('admin.widgets.head-favicons')
    @include('admin.widgets.styles')
    @stack('styles')
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    @include('admin.widgets.header')
    {!! Widget::show('aside') !!}
    <div class="content-wrapper">
        @include('admin.widgets.content-header')
        <section class="content">
            {!! Widget::show('system-message') !!}
            {!! Widget::position('outside-content-top') !!}
            @hasSection('content')
                <div class="row">
                    {!! Widget::position('inside-content-top') !!}
                    @yield('content')
                    {!! Widget::position('inside-content-bottom') !!}
                </div>
            @endif
            @yield('content-no-row')
            {!! Widget::position('outside-content-bottom') !!}
        </section>
    </div>
    {!! Widget::show('footer') !!}
</div>
@include('admin.widgets.scripts')
@stack('scripts')
</body>
</html>
