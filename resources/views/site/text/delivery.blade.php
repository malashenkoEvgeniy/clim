@php($show_menu = true)

@extends('site._layouts.text')

{{-- TODO Убрать и передавать значения с контроллера --}}
@push('viewTitle', 'Доставка и оплата')
    {{-- ENDTODO Убрать и передавать значения с контроллера --}}

@section('layout-breadcrumbs')
    <div class="section">
        <div class="container">
            @include('site._widgets.breadcrumbs.breadcrumbs', ['list' => [
                config('mock.nav-links.index'),
                config('mock.nav-links.delivery'),
            ]])
        </div>
    </div>
@endsection
@section('layout-title')
<div class="title title--size-h1">Доставка и оплата</div>
@endsection
@section('text-content')
    <article class="wysiwyg">
        <div class="scroll-text">
            <div class="scroll-text__content wysiwyg js-init"
                 data-wrap-media
                 data-prismjs
                 data-draggable-table
                 data-perfect-scrollbar
            >
              text from TinyMCE
            </div>
        </div>
    </article>
@endsection
