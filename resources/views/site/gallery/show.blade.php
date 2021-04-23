@extends('site._layouts.main')

@section('layout-body')
    <div class="section">
        <div class="container">
            <div class="box box--gap">
                <div class="title title--size-h1">{{ config('mock.gallery-view')->title }}</div>
            </div>
            <div class="box box--gap _plr-md _ptb-xs _def-plr-lg _def-ptb-md">
                <div class="grid _nm-md js-init" data-mfp="gallery">
                    @foreach(config('mock.gallery-view')->images as $item)
                        <div class="gcell gcell--6 gcell--md-4 gcell--lg-3 _p-xs _xs-p-sm _def-p-md">
                            @include('site._widgets.photo-album.photo-card--item', [
								'data' => $item,
								'mod_classes' => '',
							])
                        </div>
                    @endforeach
                </div>
                @include('site._widgets.pagination.pagination', ['show_all' => false])
                <hr class="separator _color-white _mtb-def">
            </div>
        </div>
    </div>
@endsection
