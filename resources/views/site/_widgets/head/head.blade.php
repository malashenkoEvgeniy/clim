<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>{!! Seo::site()->getTitle() !!}</title>
@if(Seo::site()->getHideDescriptionKeywords() === false)
    <meta name="description" content="{!! Seo::site()->getDescription() !!}">
    <meta name="keywords" content="{!! Seo::site()->getKeywords() !!}">
@endif
@if(Seo::site()->getCanonical())
    <link rel="canonical" href="{{ Seo::site()->getCanonical() }}"/>
@endif
@stack('meta-next-prev')
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="address=no">
<meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1, viewport-fit=cover">
@include('site._widgets.head.head-favicons.head-favicons')
@include('site._widgets.head.head-styles.head-styles')
