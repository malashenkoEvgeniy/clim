@php
    /** @var \App\Modules\Pages\Models\Page[] $pages */
    $className = \App\Modules\Pages\Models\Page::class;
@endphp

@extends('admin.layouts.main')

@section('content')
    <div class="col-xs-12">
        <div class="dd pageList" id="myNest" data-depth="1">
            <ol class="dd-list">
                @include('services::admin.rubrics.items', ['servicesRubrics' => $servicesRubrics])
            </ol>
        </div>
        <span id="parameters" data-url="{{ route('admin.services_rubrics.sortable', ['class' => $className]) }}"></span>
        <input type="hidden" id="myNestJson">
    </div>
@stop
