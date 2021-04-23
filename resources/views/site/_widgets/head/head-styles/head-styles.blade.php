{{--<link rel="preload" href="{{ site_media('static/fonts/fonts.css', true) }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="{{ site_media('static/fonts/fonts.css', true) }}"></noscript>
<script>{!! site_get_contents('static/js/cssrelpreload.min.js') !!}</script>--}}

<link rel="stylesheet" href="{{ site_media('assets/css/bundle-vendor.css', true) }}">
<link rel="stylesheet" href="{{ site_media('assets/css/bundle-common.css', true) }}">
<link rel="stylesheet" href="{{ site_media('assets/css/bundle-site.css', true) }}">
<link rel="stylesheet" href="{{ site_media('assets/css/style.css', true) }}">
@stack('head-styles')
