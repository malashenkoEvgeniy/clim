@php
/** @var \App\Modules\SiteMenu\Models\SiteMenu[][]|\Illuminate\Support\Collection $siteMenus */
$className = \App\Modules\SiteMenu\Models\SiteMenu::class;
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        <div class="dd pageList" id="myNest" data-depth="{{ $depth ?? 1 }}">
            <ol class="dd-list">
                @include('site_menu::admin.items', ['siteMenus' => $siteMenus, 'parentId' => 0])
            </ol>
        </div>
        <span id="parameters"
              data-url="{{ route('admin.site_menu.sortable', ['place' => \Route::current()->parameter('place'), 'class' => $className]) }}"></span>
        <input type="hidden" id="myNestJson">
    </div>
@stop
