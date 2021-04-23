@php
/** @var \App\Core\Modules\Images\Components\DropZone $dropZone */
/** @var \Illuminate\Database\Eloquent\Model|\App\Traits\Imageable $model */
/** @var \App\Core\Abstractions\ImageContainer $image */
@endphp

@push('styles')
    <link rel="stylesheet" href="<?php echo admin_asset('dev/dropzone.css'); ?>">
@endpush

@push('scripts')
    <script src="{{ admin_asset('dev/dropzone.js') }}"></script>
@endpush

<div class="dropModule col-md-12">
    <div class="box box-solid dropBox">
        <div class="box-header with-border">
            <i class="fa fa-download"></i>
            @lang('images::general.images-uploading')
        </div>
        <div class="box-body">
            <button class="btn btn-success dropAdd">
                <i class="fa fa-plus"></i> @lang('images::general.add-image')
            </button>
            <button class="btn btn-info dropLoad" style="display: none;">
                <i class="fa fa-download"></i> @lang('images::general.upload-image') (<span class="dropCount">0</span>)
            </button>
            <button class="btn btn-danger dropCancel" style="display: none;">
                <i class="fa fa-ban-circle"></i> @lang('images::general.cancel-all')
            </button>
        </div>
        <div class="box-body">
            <div class="dropZone"
                 data-action="{{ $dropZone->getUploadImageUrl() }}"
                 data-sortable="{{ $dropZone->getSortImagesUrl() }}"
                 data-upload="{{ $dropZone->getGetImagesListUrl() }}"
                 data-delete="{{ $dropZone->getDeleteImageUrl() }}"
                 data-id="{{ $model->id }}"
                 data-model="{{ get_class($model) }}"
                 data-type="{{ $image->getType() }}"
                 data-field="{{ $image->getField() }}"
            ></div>
        </div>
    </div>
    <div class="box box-solid loadedBox">
        <div class="box-header with-border">
            <i class="fa fa-file"></i>
            @lang('images::general.uploaded-images')
        </div>
        <div class="box-body">
            <button class="btn btn-info checkAll" style="display: none;">
                <i class="fa fa-check"></i>
                @lang('images::general.check-all')
            </button>
            <button class="btn btn-warning uncheckAll" style="display: none;">
                <i class="fa fa-ban-circle"></i>
                @lang('images::general.uncheck-all')
            </button>
            <button class="btn btn-danger removeCheck" style="display: none;">
                <i class="fa fa-remove"></i>
                @lang('images::general.delete-checked')
            </button>
        </div>
        <div class="box-body dropDownload"></div>
    </div>
</div>
<div class="clearfix"></div>
