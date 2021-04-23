@php
/** @var \App\Core\Modules\Images\Models\Image[] $images */
/** @var \Illuminate\Database\Eloquent\Model|\App\Traits\Imageable $model */
/** @var \App\Core\Modules\Images\Components\DropZone $dropZone */
@endphp

@if(count($images))
    @foreach($images AS $image)
        <div class="loadedBlockWithText loadedBlock {{ $image->active == 1 ? 'chk' : ''}}" data-image="{{ $image->id }}">
            <div class="loadedImage">
                {!! $image->imageTag('small', [], false, $image->link('original')) !!}
            </div>
            <div class="loadedControl">
                <div class="loadedCtrl loadedCheck">
                    <label>
                        <input type="checkbox">
                        <ins></ins>
                        <span class="btn btn-info" alt="@lang('images::general.check')"><i class="fa fa-check"></i></span>
                        <div class="checkInfo"></div>
                    </label>
                </div>
                <div class="loadedCtrl loadedView">
                    <a class="btn btn-primary btnImage" alt="@lang('images::general.view')" data-lightbox="gallery" href="{{ $image->link() }}">
                        <i class="fa fa-plus-square"></i>
                    </a>
                </div>
                <div class="loadedCtrl">
                    <a class="btn btn-warning" alt="@lang('images::general.edit')" href="{{ $image->edit_page_link }}">
                        <i class="fa fa-pencil"></i>
                    </a>
                </div>
                <div class="loadedCtrl loadedDelete" data-id="{{ $image->id }}">
                    <button class="btn btn-danger" data-id="{{ $image->id }}" alt="@lang('images::general.delete')"><i class="fa fa-remove"></i></button>
                </div>
            </div>
            <div class="loadedDrag"></div>
        </div>
    @endforeach
@else
    <div class="alert alert-warning">@lang('images::general.no-photo')</div>
@endif
