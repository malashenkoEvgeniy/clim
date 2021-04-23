@extends('site._layouts.main')

@section('layout-body')
    <div class="section _mb-lg">
        <div class="container _mb-xl _def-mb-xxl">
            {!! $products !!}
            <hr class="separator _color-gray3 _mtb-xl">
        </div>
    </div>
@endsection
