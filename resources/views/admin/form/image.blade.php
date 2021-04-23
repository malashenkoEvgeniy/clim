<?php
/** @var Illuminate\Support\ViewErrorBag $errors */
/** @var CustomForm\Image $element */

$error = $errors->first($element->getErrorSessionKey());
if ($error) {
    $element->addClassesToDiv('has-error');
}
$needsIcons = ($element->getImage() && $element->getImage() !== $element->getPreview()) || $element->getObject() || $element->needToShowCropButton();
?>
<div {!! Html::attributes($element->getBlockOptions()) !!}>
    @include('admin.form.components.label', ['element' => $element])
    @if($element->getPreview())
            <div class="simple-image-block">
                <img src="{{ $element->getPreview() }}">
                @if($needsIcons)
                    <div class="simple-image-actions">
                        @if($element->getImage() && $element->getImage() !== $element->getPreview())
                            <a href="{{ $element->getImage() }}" class="btn btn-xs btn-foursquare" data-lightbox="image">
                                <i class="fa fa-search-plus"></i>
                            </a>
                        @endif
                        @if($element->getObject())
                            <a href="{{ $element->getObject()->edit_page_link }}" class="btn btn-xs btn-warning">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="{{ $element->getDeleteUrl() }}" class="btn btn-xs btn-danger" data-toggle="confirmation">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        @if(!$needsIcons && $element->getDeleteUrl())
            <a href="{{ $element->getDeleteUrl() }}" class="btn btn-xs btn-danger" data-toggle="confirmation">
                <i class="fa fa-trash"></i> @lang('images::general.delete')
            </a>
        @endif
    @endif
    @if(!$element->getImage())
        {!! Form::file($element->getName(), $element->getOptions())!!}
        @include('admin.form.components.helper', ['element' => $element])
    @endif
</div>
