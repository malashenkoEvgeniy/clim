@php
/** @var \CustomForm\Builder\Buttons $buttons */
@endphp

<section class="buttons-block buttons-block--sticky col-md-12">
    @foreach ($buttons->getCustomButtons() as $button)
        {!! $button !!}
    @endforeach
    @if($buttons->needSaveButton())
        <button type="submit" class="btn btn-flat btn-m btn-success" name="submit_only">
            {{ __('buttons.save') }}
        </button>
    @endif
    @if($buttons->needSaveAndCLoseButton())
        <button type="submit" class="btn btn-flat btn-m btn-primary" name="submit_close">
            {{ __('buttons.save-and-close') }}
        </button>
    @endif
    @if($buttons->needSaveAndAddButton())
        <button type="submit" class="btn btn-flat btn-m btn-info" name="submit_add">
            {{ __('buttons.save-and-add') }}
        </button>
    @endif
    @if($buttons->needCloseButton())
        <a href="{{ $buttons->getCloseUrl() }}" class="btn btn-flat btn-m btn-danger">
            <i class="fa fa-close"></i> {{ __('buttons.close') }}
        </a>
    @endif
</section>
