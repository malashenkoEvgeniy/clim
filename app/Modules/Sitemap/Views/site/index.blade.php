@extends('site._layouts.main')

@push('head-styles')
    <link rel="stylesheet" href="{{ site_media('assets/css/bundle-sitemap.css', true) }}">
@endpush

@section('layout-body')
<div class="section _mb-lg">
    <div class="container _mb-xl _def-mb-xxl">
        <div class="box">
            <nav class="sitemap">
                @include('sitemap::site.recursive', [
                    'tree' => $tree,
                ])
            </nav>
        </div>
    </div>
</div>
@endsection
