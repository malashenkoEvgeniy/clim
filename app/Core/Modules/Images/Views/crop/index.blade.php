<?php
/**
 * @var \App\Components\Image\ImagesGroup $settings
 * @var \App\Components\Image\Image $localSettings
 * @var \Illuminate\Database\Eloquent\Model $model
 * @var \App\Core\Modules\Crop\Models\Crop $crop
 */

$default = $crop->exists ? $crop->toArray() : false;
?>
@extends('admin.layouts.main')

@push('scripts')
    <script src="{{ admin_asset('plugins/cropper/cropper.js') }}"></script>
    <script>
        var image = document.getElementById('image-to-crop');
        var cropper = new Cropper(image, {
            viewMode: 2,
            dragMode: 'move',
            autoCropArea: 1,
            aspectRatio: $('#crop-settings').data('settings').width / $('#crop-settings').data('settings').height,
            responsive: true,
            modal: true,
            rotatable: false,
            toggleDragModeOnDblclick: false,
            minCropBoxWidth: 50,
            minCropBoxHeight: 50,
            ready: function (e) {
                var $defaults = $('#crop-defaults');
                if ($defaults.length) {
                    var defaultSettings = $defaults.data('settings');
                    if (defaultSettings && defaultSettings.width && defaultSettings.height && defaultSettings.x && defaultSettings.y) {
                        cropper.setData({
                            x: parseInt(defaultSettings.x),
                            y: parseInt(defaultSettings.y),
                            width: parseInt(defaultSettings.width),
                            height: parseInt(defaultSettings.height)
                        });
                    }
                }
            },
            crop: function (e) {
                $('#crop-data').val(JSON.stringify(e.detail));
                $('#crop-submit').show();
            }
        });
    </script>
@endpush

@push('styles')
    <link href="{{ admin_asset('plugins/cropper/cropper.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="col-md-12">
        @if($default)
            <div id="crop-defaults" data-settings="{{ \Psy\Util\Json::encode($default) }}"></div>
        @endif
        <div id="crop-settings" data-settings="{{ \Psy\Util\Json::encode($localSettings->toArray()) }}"></div>
        <div class="crop-main-block col-md-10">
            <div class="sizes-list">
                @foreach($settings->imagesThatCanBeCropped() AS $sizeSettings)
                    <a href="{{ route('admin.crop.index', [
                        'id' => $model->id,
                        'back' => request()->input('back'),
                        'model' => get_class($model),
                        'size' => $sizeSettings->getFolder(),
                    ]) }}"
                       class="btn {{ $sizeSettings->getFolder() === $sizeSettings->getFolder() ? 'btn-success' : 'btn-info' }}">
                        {{ $sizeSettings->getName() }}
                    </a>
                @endforeach
            </div>
            <div style="margin-top: 10px; max-height: 500px;">
                <img id="image-to-crop" src="{{ $model->link('original') }}">
            </div>
        </div>
        <div class="col-md-2">
            {{ Form::open(['method' => 'put', 'url' => URL::full()]) }}
            {{ Form::hidden('data', null, ['id' => 'crop-data']) }}
            {{ Form::submit(trans('buttons.save'), ['style' => 'display:none;margin-left:10px;', 'id' => 'crop-submit', 'class' => 'btn btn-foursquare btn-lg btn-group-justified']) }}
            {{ Form::close() }}
            <a href="{{ request()->input('back') }}" class="btn btn-facebook btn-lg btn-group-justified"
               style="margin-left: 10px; margin-top: 10px;">@lang('global.back')</a>
        </div>
    </div>
@stop
